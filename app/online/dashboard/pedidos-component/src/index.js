import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';

// Datos de ejemplo para pedidos (fallback) y rutas
const pedidosEjemplo = [
  {
    id: "16763",
    rutCliente: "19741826-5",
    modelo: "Liso",
    tamano: "2",
    tipoTela: "Lino",
    color: "CRUDO 65",
    direccion: "Macul",
    telefono: "933762878",
    instagram: "",
    detalle: "Entregar en conserjeria",
    estado: "Pedido Listo",
    confirmacion: "Pendiente",
    observaciones: "aa"
  },
  {
    id: "16749",
    rutCliente: "25835012-K",
    modelo: "Capitone",
    tamano: "2",
    tipoTela: "felpa",
    color: "ROSA OSCURO 60",
    detalle: "",
    direccion: "Macul",
    telefono: "942985218",
    instagram: "whatsapp",
    estado: "En Fabricacion",
    confirmacion: "Pendiente",
    observaciones: ""
  },
  {
    id: "16751",
    rutCliente: "15613059-1",
    modelo: "Botone Paris",
    tamano: "2",
    tipoTela: "lino",
    color: "BEIGE OSCURO VERNACCI 60",
    detalle: "",
    direccion: "Maipú",
    telefono: "971379974",
    instagram: "local",
    estado: "Pedido Listo",
    confirmacion: "Confirmado",
    observaciones: ""
  },
  {
    id: "16752",
    rutCliente: "15613059-1",
    modelo: "Botone Madrid",
    tamano: "1",
    tipoTela: "lino",
    color: "GRIS OSCURO B2 60",
    detalle: "",
    direccion: "Maipú",
    telefono: "971379974",
    instagram: "local",
    estado: "Pedido Listo",
    confirmacion: "Confirmado",
    observaciones: ""
  },
  {
    id: "16753",
    rutCliente: "15613059-1",
    modelo: "Botone Madrid",
    tamano: "1",
    tipoTela: "lino",
    color: "GRIS OSCURO B2 60",
    detalle: "Entregar en conserjeria",
    direccion: "Maipú",
    telefono: "971379974",
    instagram: "local",
    estado: "En Fabricacion",
    confirmacion: "Confirmado",
    observaciones: ""
  },
  {
    id: "16776",
    rutCliente: "19208626-4",
    modelo: "Botone Madrid",
    tamano: "2",
    tipoTela: "Felpa",
    color: "CRUDO 60",
    detalle: "Entregar en conserjeria",
    direccion: "La Florida",
    telefono: "982043095",
    instagram: "",
    estado: "En Fabricacion",
    confirmacion: "Pendiente",
    observaciones: ""
  }
];

const rutasEjemplo = [
  {
    id: "r1",
    codigo: "ZONA-NORTE",
    fecha: "10/04/2025",
    nombre: "Ruta Norte"
  },
  {
    id: "r2",
    codigo: "ZONA-SUR",
    fecha: "11/04/2025",
    nombre: "Ruta Sur"
  },
  {
    id: "r3",
    codigo: "ZONA-ORIENTE",
    fecha: "12/04/2025",
    nombre: "Ruta Oriente"
  }
];

const rootElement = document.getElementById('root');

if (rootElement) {
  // Cargar dependencias para desarrollo local
  // Cargar Font Awesome para iconos
  if (!document.querySelector('link[href*="fontawesome"]')) {
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
    link.integrity = 'sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==';
    link.crossOrigin = 'anonymous';
    document.head.appendChild(link);
  }
  
  // Agregar meta tag para viewport
  const metaViewport = document.createElement('meta');
  metaViewport.name = 'viewport';
  metaViewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
  document.head.appendChild(metaViewport);
  
  // Agregar fuente Inter desde Google Fonts
  const interFont = document.createElement('link');
  interFont.rel = 'stylesheet';
  interFont.href = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap';
  document.head.appendChild(interFont);
  
  // Función asíncrona para obtener pedidos desde una API
  const fetchPedidos = async () => {
    try {
      // Reemplaza la siguiente URL por la de tu endpoint real
      const response = await fetch('https://api.example.com/pedidos');
      if (!response.ok) {
        throw new Error(`Error en la respuesta: ${response.status}`);
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error al obtener pedidos vía API:', error);
      // En caso de error, se usa el arreglo de pedidos de ejemplo
      return pedidosEjemplo;
    }
  };

  // Realizamos la llamada a la API y, cuando se resuelva, renderizamos la aplicación
  fetchPedidos().then((pedidosObtenidos) => {
    const root = ReactDOM.createRoot(rootElement);
    root.render(
      <React.StrictMode>
        <App 
          pedidosIniciales={pedidosObtenidos} 
          rutasIniciales={rutasEjemplo}
          onGuardarCambios={(datos) => {
            console.log('Datos guardados:', datos);
            alert(`Pedidos asignados a ruta ${datos.rutaId}.\nNúmero de pedidos: ${datos.pedidosIds.length}`);
          }}
          onEditarPedido={(pedido) => {
            console.log('Pedido editado:', pedido);
            alert(`Pedido #${pedido.id} editado correctamente.`);
            // Aquí podrías realizar una llamada a la API para actualizar el pedido en el backend
          }}
          onNotificarWhatsapp={(pedido) => {
            console.log('Enviando notificación WhatsApp para:', pedido);
            alert(`Enviando notificación WhatsApp al cliente ${pedido.rutCliente} (${pedido.telefono})`);
            // Aquí podrías realizar una llamada a la API para enviar la notificación
          }}
        />
      </React.StrictMode>
    );
  });
}

// Función global para montar el componente en tu dashboard
window.montarGestorPedidos = (elementId, opciones = {}) => {
  const elemento = document.getElementById(elementId);
  if (!elemento) {
    console.error(`Elemento con ID "${elementId}" no encontrado`);
    return;
  }
  
  // Cargar Font Awesome para iconos si no está ya cargado
  if (!document.querySelector('link[href*="font-awesome"]')) {
    const fontAwesome = document.createElement('link');
    fontAwesome.rel = 'stylesheet';
    fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
    document.head.appendChild(fontAwesome);
  }
  
  // Cargar fuente Inter si no está ya cargada
  if (!document.querySelector('link[href*="Inter"]')) {
    const interFont = document.createElement('link');
    interFont.rel = 'stylesheet';
    interFont.href = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap';
    document.head.appendChild(interFont);
  }
  
  const root = ReactDOM.createRoot(elemento);
  root.render(<App {...opciones} />);
  
  // Devuelve función para desmontar el componente si es necesario
  return () => {
    root.unmount();
  };
};
