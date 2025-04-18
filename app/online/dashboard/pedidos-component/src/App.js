import React, { useState, useEffect } from 'react';
import './App.css';

function App({ pedidosIniciales = [], rutasIniciales = [], onGuardarCambios, onNotificarWhatsapp, onEditarPedido }) {
  // Estados principales
  const [pedidos, setPedidos] = useState(pedidosIniciales);
  const [rutas, setRutas] = useState(rutasIniciales);
  const [rutaSeleccionada, setRutaSeleccionada] = useState("");
  const [filtro, setFiltro] = useState("");
  const [pedidosEnRuta, setPedidosEnRuta] = useState([]);
  const [pedidoEditando, setPedidoEditando] = useState(null);
  const [mostrarModal, setMostrarModal] = useState(false);
  
  // Estado para manejo responsive
  const [windowWidth, setWindowWidth] = useState(window.innerWidth);
  const [seccionActiva, setSeccionActiva] = useState('disponibles'); // 'disponibles' o 'seleccionados'
  useEffect(() => {
    console.log("Pedidos actualizados:", pedidos);
  }, [pedidos]);
  // Actualizar estados cuando cambian las props
  useEffect(() => {
    if (pedidosIniciales.length > 0) {
      setPedidos(pedidosIniciales);
    }
    if (rutasIniciales.length > 0) {
      setRutas(rutasIniciales);
    }
  }, [pedidosIniciales, rutasIniciales]);
  
  // Efecto para manejar el tamaño de la ventana
  useEffect(() => {
    const handleResize = () => {
      setWindowWidth(window.innerWidth);
    };
    
    window.addEventListener('resize', handleResize);
    return () => {
      window.removeEventListener('resize', handleResize);
    };
  }, []);
  
  // Determinar si estamos en vista móvil
  const isMobile = windowWidth < 768;

  // Filtrar pedidos según búsqueda
  const filtrarPedidos = (pedido) => {
    if (!filtro) return true;
    
    const termino = filtro.toLowerCase();
    return (
      (pedido.rutCliente && pedido.rutCliente.toLowerCase().includes(termino)) ||
      (pedido.modelo && pedido.modelo.toLowerCase().includes(termino)) ||
      (pedido.direccion && pedido.direccion.toLowerCase().includes(termino)) ||
      (pedido.id && pedido.id.toString().includes(termino))
    );
  };

  // Agregar o quitar pedido de la ruta
  const togglePedidoEnRuta = (pedidoId) => {
    if (pedidosEnRuta.includes(pedidoId)) {
      setPedidosEnRuta(pedidosEnRuta.filter(id => id !== pedidoId));
    } else {
      setPedidosEnRuta([...pedidosEnRuta, pedidoId]);
    }
  };

  // Agregar todos los pedidos filtrados a la ruta
  const agregarTodosARuta = () => {
    const pedidosFiltrados = pedidos
      .filter(filtrarPedidos)
      .filter(p => p.estado !== "En Ruta")
      .map(p => p.id);
    
    setPedidosEnRuta([...new Set([...pedidosEnRuta, ...pedidosFiltrados])]);
  };

  // Quitar todos los pedidos de la ruta
  const quitarTodosDeRuta = () => {
    setPedidosEnRuta([]);
  };

  // Guardar la asignación de ruta
  const guardarRuta = () => {
    if (!rutaSeleccionada) {
      alert("Por favor selecciona una ruta");
      return;
    }

    if (pedidosEnRuta.length === 0) {
      alert("No hay pedidos seleccionados para esta ruta");
      return;
    }

    // Aquí llamamos a la función proporcionada por el componente padre
    if (typeof onGuardarCambios === 'function') {
      onGuardarCambios({
        rutaId: rutaSeleccionada,
        pedidosIds: pedidosEnRuta
      });
    }
  };

  // Manejar edición de pedido
  const handleEditarPedido = (pedidoId) => {
    const pedido = pedidos.find(p => p.id === pedidoId);
    if (pedido) {
      setPedidoEditando(pedido);
      setMostrarModal(true);
    }
  };

  // Manejar notificación por WhatsApp
  const handleNotificarWhatsapp = (pedidoId) => {
    const pedido = pedidos.find(p => p.id === pedidoId);
    if (pedido && typeof onNotificarWhatsapp === 'function') {
      onNotificarWhatsapp(pedido);
    }
  };

  // Guardar cambios en el pedido editado
  const guardarCambiosPedido = () => {
    if (pedidoEditando && typeof onEditarPedido === 'function') {
      onEditarPedido(pedidoEditando);
      
      // Actualizamos el estado local para ver los cambios inmediatamente
      setPedidos(pedidos.map(p => 
        p.id === pedidoEditando.id ? pedidoEditando : p
      ));
      
      setMostrarModal(false);
      setPedidoEditando(null);
    }
  };

  // Actualizar campo de pedido editando
  const actualizarCampoPedido = (campo, valor) => {
    setPedidoEditando({
      ...pedidoEditando,
      [campo]: valor
    });
  };

  // Obtener color de fondo según estado
  const getEstadoColor = (estado) => {
    switch (estado) {
      case 'Pedido Listo': return 'estado-listo';
      case 'En Fabricacion': return 'estado-fabricacion';
      case 'Confirmado': return 'estado-confirmado';
      case 'Pendiente': return 'estado-pendiente';
      default: return '';
    }
  };
  
  // Pedidos filtrados en ruta y disponibles
  const pedidosEnRutaFiltrados = pedidos.filter(filtrarPedidos).filter(pedido => pedidosEnRuta.includes(pedido.id));
  const pedidosDisponiblesFiltrados = pedidos.filter(filtrarPedidos).filter(pedido => !pedidosEnRuta.includes(pedido.id));

  // Renderizado de las columnas de la tabla según la visibilidad responsive
  const renderColumnas = () => {
    // En móviles usamos tarjetas, no tablas
    if (isMobile) return null;
    
    return (
      <>
        <th>ID</th>
        <th>RUT Cliente</th>
        <th>Modelo</th>
        <th>Tamaño</th>
        <th>Tipo de Tela</th>
        <th>Color</th>
        <th>Detalle</th>
        <th>Dirección</th>
        <th>Estado</th>
        <th>Acciones</th>
      </>
    );
  };
  
  // Componente de tarjeta para vista móvil
  const PedidoCard = ({ pedido, index }) => {
    const enRuta = pedidosEnRuta.includes(pedido.id);
    
    return (
      <div className={`pedido-card ${enRuta ? 'selected' : ''}`}>
        <div className="pedido-card-header">
          <div className="pedido-card-id">#{pedido.id}</div>
          <div className="estado-tag-container">
            <span className={getEstadoColor(pedido.estado)}>
              {pedido.estado === 'Pedido Listo' ? 'Listo' : pedido.estado}
            </span>
            {pedido.confirmacion === 'Confirmado' && 
              <span className="confirmado-tag">✓</span>
            }
          </div>
        </div>
        
        <div className="pedido-card-body">
          <div className="pedido-card-row">
            <span className="pedido-card-label">Modelo:</span>
            <span className="pedido-card-value">{pedido.modelo}</span>
          </div>
          <div className="pedido-card-row">
            <span className="pedido-card-label">Cliente:</span>
            <span className="pedido-card-value">{pedido.rutCliente}</span>
          </div>
          <div className="pedido-card-row">
            <span className="pedido-card-label">Dirección:</span>
            <span className="pedido-card-value">{pedido.direccion}</span>
          </div>
          <div className="pedido-card-row">
            <span className="pedido-card-label">Tamaño:</span>
            <span className="pedido-card-value">{pedido.tamano}</span>
          </div>
          <div className="pedido-card-row">
            <span className="pedido-card-label">Color:</span>
            <span className="pedido-card-value">{pedido.color}</span>
          </div>
          <div className="pedido-card-row">
            <span className="pedido-card-label">Detalle:</span>
            <span className="pedido-card-value">{pedido.detalle}</span>
          </div>
        </div>
        
        <div className="pedido-card-footer">
          <button 
            onClick={() => handleEditarPedido(pedido.id)} 
            className="pedido-card-btn edit"
            aria-label="Editar pedido"
          >
            <i className="fas fa-edit"></i>
          </button>
          <button 
            onClick={() => handleNotificarWhatsapp(pedido.id)} 
            className="pedido-card-btn whatsapp"
            aria-label="Notificar por WhatsApp"
          >
            <i className="fab fa-whatsapp"></i>
          </button>
          <button 
            onClick={() => togglePedidoEnRuta(pedido.id)} 
            className={`pedido-card-btn ${enRuta ? 'remove' : 'add'}`}
            aria-label={enRuta ? "Quitar de ruta" : "Agregar a ruta"}
          >
            <i className={`fas ${enRuta ? 'fa-minus-circle' : 'fa-plus-circle'}`}></i>
            {enRuta ? 'Quitar' : 'Agregar'}
          </button>
        </div>
      </div>
    );
  };

  return (
    <div className="pedidos-container">
      {/* Encabezado */}
      <div className="header-container">
        <h2>Gestión de Pedidos y Rutas</h2>
        
        <div className="acciones-container">
          <div className="busqueda-container">
            <input
              type="text"
              placeholder="Buscar por ID, cliente, modelo, dirección..."
              value={filtro}
              onChange={(e) => setFiltro(e.target.value)}
              className="busqueda-input"
            />
          </div>
          
          <div className="ruta-selector">
            <select 
              value={rutaSeleccionada} 
              onChange={(e) => setRutaSeleccionada(e.target.value)}
              className="ruta-select"
            >
              <option value="">Seleccionar ruta</option>
              {rutas.map(ruta => (
                <option key={ruta.id} value={ruta.id}>
                  {ruta.nombre || ruta.codigo} ({ruta.fecha})
                </option>
              ))}
            </select>
            
            <button 
              onClick={guardarRuta} 
              className="btn btn-primary"
              disabled={!rutaSeleccionada || pedidosEnRuta.length === 0}
            >
              ORGANIZAR RUTA
            </button>
          </div>
        </div>
      </div>
      
      {/* Pestañas para móvil */}
      {isMobile && (
        <div className="seccion-tabs">
          <div 
            className={`seccion-tab ${seccionActiva === 'seleccionados' ? 'activa' : ''}`}
            onClick={() => setSeccionActiva('seleccionados')}
          >
            Seleccionados
            <span className="seccion-counter">{pedidosEnRuta.length}</span>
          </div>
          <div 
            className={`seccion-tab ${seccionActiva === 'disponibles' ? 'activa' : ''}`}
            onClick={() => setSeccionActiva('disponibles')}
          >
            Disponibles
            <span className="seccion-counter">{pedidosDisponiblesFiltrados.length}</span>
          </div>
        </div>
      )}
      
      {/* Tabla de pedidos en ruta */}
      {(!isMobile || (isMobile && seccionActiva === 'seleccionados')) && (
        <div className={`tabla-seccion ${isMobile ? 'mobile-view' : ''}`}>
          {!isMobile && (
            <>
              <h3>Pedidos seleccionados para ruta ({pedidosEnRuta.length})</h3>
              
              <div className="acciones-masivas">
                <button 
                  onClick={agregarTodosARuta} 
                  className="btn btn-success"
                >
                  Agregar Todos
                </button>
                <button 
                  onClick={quitarTodosDeRuta} 
                  className="btn btn-danger"
                  disabled={pedidosEnRuta.length === 0}
                >
                  Quitar Todos
                </button>
              </div>
            </>
          )}
          
          {isMobile ? (
            // Vista de tarjetas para móvil
            <div className="content-with-fixed-footer">
              {pedidosEnRutaFiltrados.length === 0 ? (
                <div className="estado-vacio">
                  <i className="fas fa-inbox"></i>
                  <p>No hay pedidos seleccionados</p>
                </div>
              ) : (
                pedidosEnRutaFiltrados.map((pedido, index) => (
                  <PedidoCard 
                    key={pedido.id} 
                    pedido={pedido} 
                    index={index} 
                  />
                ))
              )}
            </div>
          ) : (
            // Vista de tabla para desktop
            <div className="tabla-container">
              <table className="tabla-pedidos">
                <thead>
                  <tr>
                    {renderColumnas()}
                  </tr>
                </thead>
                <tbody>
                  {pedidosEnRutaFiltrados.map((pedido, index) => (
                    <tr key={pedido.id} className={pedidosEnRuta.includes(pedido.id) ? 'seleccionado' : ''}>
                      <td>{pedido.id}</td>
                      <td>{pedido.rutCliente}</td>
                      <td>{pedido.modelo}</td>
                      <td>{pedido.tamano}</td>
                      <td className="columna-tipotela">{pedido.tipoTela}</td>
                      <td className="columna-color">{pedido.color}</td>
                      <td>{pedido.detalle || "-"}</td> {/* Nueva columna */}
                      <td>{pedido.direccion}</td>
                      <td>
                        <div className="estado-tag-container">
                          <span className={getEstadoColor(pedido.estado)}>
                            {pedido.estado === 'Pedido Listo' ? 'Listo' : pedido.estado}
                          </span>
                          {pedido.confirmacion === 'Confirmado' && 
                            <span className="confirmado-tag">✓</span>
                          }
                        </div>
                      </td>
                      <td className="acciones-column">
                        <button 
                          onClick={() => handleEditarPedido(pedido.id)} 
                          className="btn btn-secondary btn-sm"
                          title="Editar pedido"
                        >
                          <i className="fas fa-edit"></i>
                        </button>
                        <button 
                          onClick={() => handleNotificarWhatsapp(pedido.id)} 
                          className="btn btn-whatsapp btn-sm"
                          title="Notificar por WhatsApp"
                        >
                          <i className="fab fa-whatsapp"></i>
                        </button>
                        <button 
                          onClick={() => togglePedidoEnRuta(pedido.id)} 
                          className="btn btn-danger btn-sm"
                          title="Borrar de ruta"
                        >
                          <i className="fas fa-minus-circle"></i>
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      )}
      
      {/* Tabla de pedidos disponibles */}
      {(!isMobile || (isMobile && seccionActiva === 'disponibles')) && (
        <div className={`tabla-seccion ${isMobile ? 'mobile-view' : ''}`}>
          {!isMobile && <h3>PEDIDOS DISPONIBLES PARA AGREGAR A RUTA</h3>}
          
          {isMobile ? (
            // Vista de tarjetas para móvil
            <div className="content-with-fixed-footer">
              {pedidosDisponiblesFiltrados.length === 0 ? (
                <div className="estado-vacio">
                  <i className="fas fa-inbox"></i>
                  <p>No se encontraron pedidos disponibles</p>
                </div>
              ) : (
                pedidosDisponiblesFiltrados.map((pedido, index) => (
                  <PedidoCard 
                    key={pedido.id} 
                    pedido={pedido} 
                    index={index} 
                  />
                ))
              )}
            </div>
          ) : (
            // Vista de tabla para desktop
            <div className="tabla-container">
              <table className="tabla-pedidos">
                <thead>
                  <tr>
                    {renderColumnas()}
                  </tr>
                </thead>
                <tbody>
                  {pedidosDisponiblesFiltrados.map((pedido, index) => (
                    <tr key={pedido.id}>
                      <td>{pedido.id}</td>
                      <td>{pedido.rutCliente}</td>
                      <td>{pedido.modelo}</td>
                      <td>{pedido.tamano}</td>
                      <td className="columna-tipotela">{pedido.tipoTela}</td>
                      <td className="columna-color">{pedido.color}</td>
                      <td>{pedido.detalle}</td>
                      <td>{pedido.direccion}</td>
                      <td>
                        <div className="estado-tag-container">
                          <span className={getEstadoColor(pedido.estado)}>
                            {pedido.estado === 'Pedido Listo' ? 'Listo' : pedido.estado}
                          </span>
                          {pedido.confirmacion === 'Confirmado' && 
                            <span className="confirmado-tag">✓</span>
                          }
                        </div>
                      </td>
                      <td className="acciones-column">
                        <button 
                          onClick={() => handleEditarPedido(pedido.id)} 
                          className="btn btn-secondary btn-sm"
                          title="Editar pedido"
                        >
                          <i className="fas fa-edit"></i>
                        </button>
                        <button 
                          onClick={() => handleNotificarWhatsapp(pedido.id)} 
                          className="btn btn-whatsapp btn-sm"
                          title="Notificar por WhatsApp"
                        >
                          <i className="fab fa-whatsapp"></i>
                        </button>
                        <button 
                          onClick={() => togglePedidoEnRuta(pedido.id)} 
                          className="btn btn-success btn-sm"
                          title="Agregar a ruta"
                        >
                          <i className="fas fa-plus-circle"></i>
                        </button>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      )}
      
      {/* Barra de acciones fija para móviles */}
      {isMobile && (
        <div className="mobile-actions">
          <button 
            className="mobile-actions-btn secondary"
            onClick={() => setSeccionActiva(seccionActiva === 'disponibles' ? 'seleccionados' : 'disponibles')}
          >
            <i className={`fas ${seccionActiva === 'disponibles' ? 'fa-check-circle' : 'fa-th-list'}`}></i>
            {seccionActiva === 'disponibles' ? 'Ver Seleccionados' : 'Ver Disponibles'}
          </button>
          <button 
            className="mobile-actions-btn primary"
            onClick={guardarRuta}
            disabled={!rutaSeleccionada || pedidosEnRuta.length === 0}
          >
            <i className="fas fa-route"></i>
            Organizar Ruta ({pedidosEnRuta.length})
          </button>
        </div>
      )}
      
      {/* Modal de edición con diseño mejorado */}
      {mostrarModal && pedidoEditando && (
        <div className="modal-overlay">
          <div className="modal-container">
            <div className="modal-header">
              <h3>
                <i className="fas fa-edit"></i> 
                Editar Pedido #{pedidoEditando.id}
              </h3>
              <button 
                onClick={() => {
                  setMostrarModal(false);
                  setPedidoEditando(null);
                }}
                className="modal-close"
                aria-label="Cerrar"
              >
                &times;
              </button>
            </div>
            <div className="modal-body">
              <div className="form-grid">
                <div className="form-group">
                  <label htmlFor="edit-cliente">Cliente (RUT):</label>
                  <input 
                    id="edit-cliente"
                    type="text" 
                    value={pedidoEditando.rutCliente || ''} 
                    onChange={(e) => actualizarCampoPedido('rutCliente', e.target.value)}
                    className="form-control"
                    placeholder="Ej: 12345678-9"
                  />
                </div>

                <div className="form-group">
                  <label htmlFor="edit-modelo">Modelo:</label>
                  <select 
                    id="edit-modelo"
                    value={pedidoEditando.modelo || ''} 
                    onChange={(e) => actualizarCampoPedido('modelo', e.target.value)}
                    className="form-control"
                  >
                    <option value="">Seleccionar modelo</option>
                    <option value="Liso">Liso</option>
                    <option value="Capitone">Capitone</option>
                    <option value="Botone Madrid">Botone Madrid</option>
                    <option value="Botone Paris">Botone Paris</option>
                    <option value="Tubular Vertical">Tubular Vertical</option>
                    <option value="Liso Completo mdf">Liso Completo mdf</option>
                  </select>
                </div>

                <div className="form-group">
                  <label htmlFor="edit-tamano">Tamaño:</label>
                  <select
                    id="edit-tamano"
                    value={pedidoEditando.tamano || ''} 
                    onChange={(e) => actualizarCampoPedido('tamano', e.target.value)}
                    className="form-control"
                  >
                    <option value="">Seleccionar tamaño</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="King">King</option>
                    <option value="Super King">Super King</option>
                    <option value="1 1/2">1 1/2</option>
                  </select>
                </div>

                <div className="form-group">
                  <label htmlFor="edit-tela">Tipo de Tela:</label>
                  <select
                    id="edit-tela"
                    value={pedidoEditando.tipoTela || ''} 
                    onChange={(e) => actualizarCampoPedido('tipoTela', e.target.value)}
                    className="form-control"
                  >
                    <option value="">Seleccionar tipo de tela</option>
                    <option value="lino">Lino</option>
                    <option value="felpa">Felpa</option>
                    <option value="Lino">Lino</option>
                    <option value="Felpa">Felpa </option>
                    <option value="Albaytalde">Albaytalde</option>
                  </select>
                </div>

                <div className="form-group">
                  <label htmlFor="edit-color">Color:</label>
                  <input 
                    id="edit-color"
                    type="text" 
                    value={pedidoEditando.color || ''} 
                    onChange={(e) => actualizarCampoPedido('color', e.target.value)}
                    className="form-control"
                    placeholder="Ej: CRUDO 60"
                  />
                </div>

                <div className="form-group">
                  <label htmlFor="edit-direccion">Dirección:</label>
                  <input 
                    id="edit-direccion"
                    type="text" 
                    value={pedidoEditando.direccion || ''} 
                    onChange={(e) => actualizarCampoPedido('direccion', e.target.value)}
                    className="form-control"
                    placeholder="Ej: Maipú"
                  />
                </div>

                <div className="form-group">
                  <label htmlFor="edit-telefono">Teléfono:</label>
                  <input 
                    id="edit-telefono"
                    type="text" 
                    value={pedidoEditando.telefono || ''} 
                    onChange={(e) => actualizarCampoPedido('telefono', e.target.value)}
                    className="form-control"
                    placeholder="Ej: 912345678"
                  />
                </div>

                <div className="form-group">
                  <label htmlFor="edit-instagram">Instagram:</label>
                  <input 
                    id="edit-instagram"
                    type="text" 
                    value={pedidoEditando.instagram || ''} 
                    onChange={(e) => actualizarCampoPedido('instagram', e.target.value)}
                    className="form-control"
                    placeholder="Ej: usuario.instagram"
                  />
                </div>

                <div className="form-group">
                  <label htmlFor="edit-estado">Estado:</label>
                  <select 
                    id="edit-estado"
                    value={pedidoEditando.estado || ''} 
                    onChange={(e) => actualizarCampoPedido('estado', e.target.value)}
                    className="form-control"
                  >
                    <option value="Pedido Listo">Pedido Listo</option>
                    <option value="En Fabricacion">En Fabricación</option>
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmado">Confirmado</option>
                  </select>
                </div>

                <div className="form-group">
                  <label htmlFor="edit-confirmacion">Confirmación:</label>
                  <select 
                    id="edit-confirmacion"
                    value={pedidoEditando.confirmacion || ''} 
                    onChange={(e) => actualizarCampoPedido('confirmacion', e.target.value)}
                    className="form-control"
                  >
                    <option value="Pendiente">Pendiente</option>
                    <option value="Confirmado">Confirmado</option>
                  </select>
                </div>

                <div className="form-group full-width">
                  <label htmlFor="edit-observaciones">Observaciones:</label>
                  <textarea
                    id="edit-observaciones"
                    value={pedidoEditando.observaciones || ''} 
                    onChange={(e) => actualizarCampoPedido('observaciones', e.target.value)}
                    className="form-control"
                    placeholder="Notas adicionales o comentarios sobre el pedido..."
                    rows="3"
                  ></textarea>
                </div>
              </div>
            </div>
            <div className="modal-footer">
              <button 
                onClick={() => {
                  setMostrarModal(false);
                  setPedidoEditando(null);
                }}
                className="btn btn-outline"
              >
                <i className="fas fa-times"></i> Cancelar
              </button>
              <button 
                onClick={guardarCambiosPedido}
                className="btn btn-primary"
              >
                <i className="fas fa-save"></i> Guardar Cambios
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

export default App;