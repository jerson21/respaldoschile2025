<?php 
	const BASE_URL = "http://localhost/respaldoschile";
	//http://localhost:8000/respaldoschile
	//const BASE_URL = "https://abelosh.com/tiendavirtual"; 
	//const BASE_URL = "https://respaldoschile.cl";

	//Zona horaria
	date_default_timezone_set('America/Santiago');
	$dotenv = parse_ini_file(__DIR__ . '/../.env'); // ruta según tu estructura


	//Datos de conexión a Base de Datos
	define('DB_HOST', $dotenv['DB_HOST']);
	const DB_NAME = "cre61650_db_tiendadb";
	const DB_USER = "cre61650_respaldos21";
	const DB_PASSWORD = "respaldos21/";


	const DB_HOST2 = "localhost";
	const DB_NAME2 = "cre61650_agenda";
	const DB_USER2 = "cre61650_respaldos21";
	const DB_PASSWORD2 = "respaldos21/";



	/*const DB_NAME = "db_tiendavirtual";
	const DB_USER = "root";
	const DB_PASSWORD = "";*/
	const DB_CHARSET = "utf8";

	//Para envío de correo
	const ENVIRONMENT = 1; // Local: 0, Produccón: 1;

	//Deliminadores decimal y millar Ej. 24,1989.00
	const SPD = ".";
	const SPM = ",";

	//Simbolo de moneda
	const SMONEY = "$";
	const CURRENCY = "USD";

	//Api PayPal
	//SANDBOX PAYPAL
	const URLPAYPAL = "https://api-m.sandbox.paypal.com";
	const IDCLIENTE = "";
	const SECRET = "";
	//LIVE PAYPAL
	//const URLPAYPAL = "https://api-m.paypal.com";
	//const IDCLIENTE = "";
	//const SECRET = "";

	//Datos envio de correo
	const NOMBRE_REMITENTE = "RedecoMuebles";
	const EMAIL_REMITENTE = "contacto@respaldoschile.cl";
	const NOMBRE_EMPESA = "RedecoMuebles";
	const WEB_EMPRESA = "www.respaldoschile.cl";

	const DESCRIPCION = "Tienda de productos para el hogar.";
	const SHAREDHASH = "TiendaVirtual";

	//Datos Empresa
	const DIRECCION = "Av uno 10185, La Florida, Santiago";
	const TELEMPRESA = "+56979941253";
	const WHATSAPP = "+56979941253";
	const EMAIL_EMPRESA = "contacto@respaldoschile.cl";
	const EMAIL_PEDIDOS = "contacto@respaldoschile.cl"; 
	const EMAIL_SUSCRIPCION = "contacto@respaldoschile.cl";
	const EMAIL_CONTACTO = "contacto@respaldoschile.cl";

	const CAT_SLIDER = "1,2,3";
	const CAT_BANNER = "4,5,6";
	const CAT_FOOTER = "1,2,3,4,5";

	//Datos para Encriptar / Desencriptar
	const KEY = 'abelosh';
	const METHODENCRIPT = "AES-128-ECB";

	//Envío
	const COSTOENVIO = 5;

	//Módulos
	const MDASHBOARD = 1;
	const MUSUARIOS = 2;
	const MCLIENTES = 3;
	const MPRODUCTOS = 4;
	const MPEDIDOS = 5;
	const MCATEGORIAS = 6;
	const MSUSCRIPTORES = 7;
	const MDCONTACTOS = 8;
	const MDPAGINAS = 9;

	//Páginas
	const PINICIO = 1;
	const PTIENDA = 2;
	const PCARRITO = 3;
	const PNOSOTROS = 4;
	const PCONTACTO = 5;
	const PPREGUNTAS = 6;
	const PTERMINOS = 7;
	const PSUCURSALES = 8;
	const PERROR = 9;

	//Roles
	const RADMINISTRADOR = 1;
	const RSUPERVISOR = 2;
	const RCLIENTES = 3;

	const STATUS = array('Completo','Aprobado','Cancelado','Reembolsado','Pendiente','Entregado');

	//Productos por página
	const CANTPORDHOME = 8;
	const PROPORPAGINA = 4;
	const PROCATEGORIA = 4;
	const PROBUSCAR = 4;

	//REDES SOCIALES
	const FACEBOOK = "";
	const INSTAGRAM = "https://www.instagram.com/respaldoschile";
	

 ?>