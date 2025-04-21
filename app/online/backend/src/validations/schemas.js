const Joi = require('joi');

const clienteSchema = Joi.object({
  rut: Joi.string().required(),
  nombre: Joi.string().required(),
  telefono: Joi.string().allow(''),
  correo: Joi.string().email().allow(''),
  instagram: Joi.string().allow('')
});

const pedidoSchema = Joi.object({
  rut_cliente: Joi.string().required(),
  fecha_ingreso: Joi.date().required(),
  despacho: Joi.string().required(),
  total_pagado: Joi.number().required(),
  vendedor: Joi.string().required(),
  metodo_entrega: Joi.string().required(),
  estado: Joi.string().required(),
  orden_ext: Joi.string().required()
});

const pagoSchema = Joi.object({
  num_orden: Joi.number().required(),
  metodo_pago: Joi.string().required(),
  monto: Joi.number().required(),
  usuario: Joi.string().required(),
  fecha_mov: Joi.date().required(),
  id_cartola: Joi.string().allow(''),
  datos_adicionales: Joi.string().allow('')
});

module.exports = {
  clienteSchema,
  pedidoSchema,
  pagoSchema
}; 