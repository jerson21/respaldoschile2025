const model = require('../models/pedidoDetalleModel');

// Asumiendo que 'io' se inicializa en tu archivo principal y se adjunta a la app
// const io = req.app.get('io'); // Esto ya está en la función update

/**
 * Controller de detalles de pedido.
 */
async function getAll(req, res) {
  try {
    const pedidoId = req.params.pedidoId;
    const detalles = await model.getAllByOrder(pedidoId);
    res.json({ status: 'success', data: detalles });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener detalles.' });
  }
}

async function getById(req, res) {
  try {
    const id = req.params.id;
    const detalle = await model.getById(id);
    if (!detalle) {
      return res.status(404).json({ status: 'error', error: 'Detalle no encontrado.' });
    }
    res.json({ status: 'success', data: detalle });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al obtener detalle.' });
  }
}

// Lista blanca de campos permitidos en detalles de pedido
const ALLOWED_FIELDS = [
  'direccion', 'numero', 'dpto', 'region', 'comuna',
  'modelo', 'tamano', 'alturabase', 'tipotela', 'color',
  'precio', 'abono', 'cantidad', 'tipo_boton', 'anclaje',
  'comentarios', 'detalles_fabricacion', 'fecha_ingreso',
  'pagado', 'mododepago', 'metodo_entrega', 'detalle_entrega',
  'vendedor', 'estadopedido', 'ruta_asignada', 'orden_ruta',
  'confirma', 'tapicero_id'
];

async function create(req, res) {
  try {
    // Construir objeto solo con campos permitidos
    const data = {};
    ALLOWED_FIELDS.forEach(key => {
      if (req.body[key] !== undefined) data[key] = req.body[key];
    });
    data.num_orden = req.params.pedidoId;
    const id = await model.create(data);
    // Obtener el detalle completo recién creado para enviar al cliente
    const newDetail = await model.getById(id);
    // Emitir evento de nueva tarea asignada al tapicero correspondiente
    const io = req.app.get('io');
    if (data.tapicero_id !== undefined && data.tapicero_id !== null) {
       // 'taskCreated' para insertar en la UI sin reconsulta
       io.to(`tapicero-${data.tapicero_id}`).emit('taskCreated', newDetail);
       console.log(`[${new Date().toISOString()}] ◀ taskCreated id=${id}:`, newDetail);
    } else {
       console.log(`Detalle ${id} creado sin tapicero_id. No se emite taskCreated.`);
    }
    res.status(201).json({ status: 'success', id });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al crear detalle.' });
  }
}


async function update(req, res) {
  try {
    const id = req.params.id;
    // Construir objeto solo con campos permitidos
    const data = {};
    ALLOWED_FIELDS.forEach(key => {
      if (req.body[key] !== undefined) data[key] = req.body[key];
    });

    // *** Importante: Obtener el detalle ANTES de la actualización si necesitas el tapicero_id anterior
    // para emitir a la sala correcta, en caso de que tapicero_id sea uno de los campos actualizados.
    // Si tapicero_id NUNCA se actualiza a través de esta ruta PUT, puedes omitir esto.
    // Asumiremos que tapicero_id PUEDE ser actualizado.
    const oldDetail = await model.getById(id);
    if (!oldDetail) {
         return res.status(404).json({ status: 'error', error: 'Detalle no encontrado para actualizar.' });
    }
    const oldTapiceroId = oldDetail.tapicero_id;


    console.log(`[${new Date().toISOString()}] ▶ UPDATE pedido_detalle id=${id} data=`, data);
    const affected = await model.update(id, data); // <-- 1. Actualización en DB
    console.log(`[${new Date().toISOString()}] ◀ UPDATE pedido_detalle affectedRows=`, affected);

    if (!affected) {
      // Aunque no haya filas afectadas, si el detalle existía, podríamos querer emitir si el estado era 6
      // para asegurar que desaparezca si ya no cumple el filtro de fecha.
      // Sin embargo, si no se encontró el detalle (404), no hacemos nada más.
       // Si affected es 0, podría significar que los datos enviados eran idénticos a los existentes.
       // En ese caso, la base de datos no reporta filas afectadas, pero lógicamente no hay cambio.
       // Podríamos optar por no emitir el socket si affected es 0, a menos que un cambio de estado
       // a 6 necesite forzar un refresco incluso si no hay cambio en otros campos.
       // Por ahora, mantenemos la emisión si el detalle existía.
    }

    // Si el estado cambió a 3 (inicio de producción), registrar la etapa en pedido_etapas
    // O si el estado cambió a 6 (terminado), registrar la etapa 6
    // Debes definir qué idproceso corresponde a cada estado relevante (3, 5, 6, 8)
    // Asumiremos que 3 es inicio, 5 es en proceso, 6 es terminado.
    const newEstado = parseInt(data.estadopedido);
    if (data.estadopedido !== undefined && [3, 5, 6, 8].includes(newEstado)) {
       try {
          console.log(`[${new Date().toISOString()}] ▶ INSERT pedido_etapas idPedido=${id}, idproceso=${newEstado}`);
          const etapaInsertId = await model.addEtapaDetalle(id, newEstado);
          console.log(`[${new Date().toISOString()}] ◀ INSERT pedido_etapas insertId=`, etapaInsertId);
       } catch (err) {
          console.error(`Error al insertar etapa detalle ${newEstado} para id ${id}:`, err);
       }
    }

    // Obtener detalle actualizado para determinar el tapicero_id actual y nuevo (si cambió)
    // Esta lectura es necesaria para saber a qué sala(s) emitir el evento.
    // La movemos DESPUÉS de registrar la etapa, si aplica.
    const updatedDetail = await model.getById(id);
    console.log(`[${new Date().toISOString()}] ◀ Updated detalle id=${id}:`, updatedDetail);
    if (!updatedDetail) {
        // Si el detalle desapareció después de la actualización (muy raro), loggear y salir.
        console.error(`Detalle ${id} no encontrado DESPUÉS de la actualización.`);
         // Podríamos emitir un evento de "tarea eliminada" si esto fuera un escenario válido
         // io.to(`tapicero-${oldTapiceroId}`).emit('taskDeleted', { id: id, tapicero_id: oldTapiceroId });
        return res.status(500).json({ status: 'error', error: 'Error interno al verificar detalle actualizado.' });
    }
    const currentTapiceroId = updatedDetail.tapicero_id;


    // *** CORRECCIÓN CLAVE: Emitir evento de Socket.io AQUÍ ***
    // Emitimos después de la actualización de la base de datos y (si aplica) después de registrar la etapa,
    // pero antes de enviar la respuesta al cliente que inició la petición.
    // Emitimos a la sala del tapicero ANTERIOR (si cambió) y a la sala del tapicero ACTUAL.
    const io = req.app.get('io');

    // Emitir a la sala del tapicero anterior si el tapicero cambió
    if (oldTapiceroId !== currentTapiceroId && oldTapiceroId !== null && oldTapiceroId !== undefined) {
         io.to(`tapicero-${oldTapiceroId}`).emit('taskUpdated', { id: id, tapicero_id: oldTapiceroId });
         console.log(`Emitido taskUpdated a sala tapicero-${oldTapiceroId} (tapicero anterior)`);
    }

    // Emitir a la sala del tapicero actual (si tiene tapicero asignado)
    if (currentTapiceroId !== null && currentTapiceroId !== undefined) {
        // Enviamos solo el ID y el tapicero_id en el payload, ya que el frontend refresca todos los datos.
        io.to(`tapicero-${currentTapiceroId}`).emit('taskUpdated', { id: id, tapicero_id: currentTapiceroId });
        console.log(`Emitido taskUpdated a sala tapicero-${currentTapiceroId} (tapicero actual)`);
    } else {
         // Si el tapicero_id es null/unassigned ahora, emitir a una sala 'unassigned' si existe
         console.log(`Detalle ${id} actualizado sin tapicero_id asignado. No se emite taskUpdated a sala específica.`);
         // Opcional: emitir a una sala 'unassigned' si tienes una
         // io.to('tapicero-unassigned').emit('taskUpdated', { id: id, tapicero_id: null });
    }
    // ********************************************************


    // La respuesta al cliente que inició la petición se envía DESPUÉS de emitir el Socket
    res.json({ status: 'success', updated: affected });

  } catch (error) {
    console.error('Error en la función update de pedidoDetallesController:', error);
    res.status(500).json({ status: 'error', error: 'Error al actualizar detalle.' });
  }
}

async function remove(req, res) {
  try {
    const id = req.params.id;
    // Opcional: Obtener tapicero_id antes de eliminar para emitir un evento de eliminación
    // const detailToDelete = await model.getById(id);

    const affected = await model.remove(id);
    if (!affected) {
      return res.status(404).json({ status: 'error', error: 'Detalle no encontrado.' });
    }

    // Opcional: Emitir evento de tarea eliminada
    // if (detailToDelete && detailToDelete.tapicero_id !== null && detailToDelete.tapicero_id !== undefined) {
    //    const io = req.app.get('io');
    //    io.to(`tapicero-${detailToDelete.tapicero_id}`).emit('taskDeleted', { id: id, tapicero_id: detailToDelete.tapicero_id });
    // }

    res.json({ status: 'success', message: 'Detalle eliminado.' });
  } catch (error) {
    console.error(error);
    res.status(500).json({ status: 'error', error: 'Error al eliminar detalle.' });
  }
}

/**
 * Reordena varios detalles de pedido ajustando su campo orden_ruta.
 * PATCH /api/pedidos/:pedidoId/detalles/reorder
 */
async function reorderDetails(req, res) {
  const { ordering } = req.body;
  if (!Array.isArray(ordering)) {
    return res.status(400).json({ status: 'error', error: 'El cuerpo debe incluir un arreglo ordering.' });
  }
  try {
    // Actualiza en paralelo cada detalle
    await Promise.all(
      ordering.map(item => model.updateOrden(item.id, item.orden_ruta))
    );
    // Opcional: Emitir un evento de Socket.io general o por tapicero si reordenar afecta la vista
    // Esto dependerá de si la reordenación impacta la vista de tareas del tapicero de manera significativa.
    // Si solo afecta el orden de ruta para despachos, no sería necesario emitir aquí.

    res.json({ status: 'ok' });
  } catch (e) {
    console.error('Error en reorderDetails:', e);
    res.status(500).json({ status: 'error', error: 'Error al reordenar detalles.' });
  }
}


module.exports = { getAll, getById, create, update, remove, reorderDetails };
