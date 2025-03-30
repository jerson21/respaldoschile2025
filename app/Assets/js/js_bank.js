  

function pago() {
    const totalAPagar = document.getElementById('totalAPagar').textContent;  // Asumo que esto es el monto a pagar que ya calculaste.
    // Capitaliza el método de pago del cliente
    mododepago = document.getElementById('cliente-modo-pago').textContent;

    // Define el contenido HTML dinámico según el método de pago
    let metodoPagoCliente = mododepago.toLowerCase();
    let htmlContent;

    if (metodoPagoCliente === 'debito' || metodoPagoCliente === 'credito') {
        htmlContent = `
            <div class="payment-method-selection">
                <div style="border: 2px solid #4CAF50; border-radius: 10px; padding: 15px; margin-bottom: 10px;">
                    <button class="bank-button" onclick="pay(${totalAPagar})">Transferencia</button>
                    <p class="payment-info">Paga directamente desde tu cuenta bancaria. Podemos validar el pago automáticamente. ¡Es más rápido y seguro!</p>
                </div>
                <div style="border: 1px solid #ccc; border-radius: 10px; padding: 15px;">
                    <form id="webpayForm" action="procesar_pago_webpay.php" method="POST">
                        <input type="hidden" id="amountInput" name="amount" value="0"> <!-- El valor se establecerá dinámicamente -->
                        <input type="hidden" id="webpaynum_orden" name="webpaynum_orden" value="0"> <!-- Asegúrate de que el PHP se procese correctamente -->
                        <button type="button" class="webpay-button" onclick="payByWebpay()">Pagar con Webpay</button>
                    </form>
                    <p class="payment-info">Utiliza tu tarjeta de crédito o débito.</p>
                </div>
            </div>`;

        // Mostrar SweetAlert2 con el contenido dinámico
        Swal.fire({
            title: 'Selecciona Método de Pago',
            html: htmlContent,
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'custom-swal-popup'
            

            }
        });
    } else {
        pay();
    }
}


// Función para capitalizar palabras
function ucwords(str) {
return str.replace(/\b\w/g, function(l) { return l.toUpperCase(); });
}


function pay() {
    const orderId = <?php echo $_GET['id']; ?>;  // Asegúrate de que el PHP se procese correctamente.
    
    // Obtener primero el monto total a pagar
    fetchTotalPrice(orderId).then(totalAPagar => {
        Swal.fire({
            title: 'Selecciona tu Banco',
            html: `
                <div class="bank-selection">
                    <img src="<?= media(); ?>/images/banc/2024212162213BancoEstado_General_MDP_022024.png" onclick="selectBank('BancoEstado')" alt="Banco Estado">
                    <img src="<?= media(); ?>/images/banc/2022102513251120211021151441BancoDeChile.png" onclick="selectBank('BancoDeChile')" alt="Banco de Chile">
                    <img src="<?= media(); ?>/images/banc/20211021152820santander.png" onclick="selectBank('BancoSantander')" alt="Santander">
                    <img src="<?= media(); ?>/images/banc/202421216201520230413123142MedioPagoBCI.png" onclick="selectBank('BCI')" alt="BCI">
                    <img src="<?= media(); ?>/images/banc/2024228162310MACH_MDP_022024.png" onclick="selectBank('Mach')" alt="MACH">
                    <img src="<?= media(); ?>/images/banc/202351818232020211021152053Itau.png" onclick="selectBank('BancoItau')" alt="Itaú">
                    <img src="<?= media(); ?>/images/banc/202415224744BancoFalabella.png" onclick="selectBank('BancoFalabella')" alt="Banco Falabella">
                    <img src="<?= media(); ?>/images/banc/bice.png" onclick="selectBank('BancoBice')" alt="Banco Bice">
                    <img src="<?= media(); ?>/images/banc/Logo_Ripley_banco_2.png" onclick="selectBank('BancoRipley')" alt="Banco Ripley">
                    <button class="banks-button" onclick="showOtherBanks()"><i class="fas fa-building"></i> Otros Bancos</button>
                    <p class="transaction-confirmation">
                        <i class="fas fa-check-circle"></i> Confirmaremos la recepción de su transferencia en nuestra cuenta de forma inmediata.
                      
                    </p>
                    <br><strong>Total a Pagar: $${totalAPagar}</strong>
                </div>`,
            showCancelButton: true,
            showConfirmButton: false,
            allowOutsideClick: false,
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'custom-swal-popup'
            }
        });
    }).catch(error => {
        console.error('Error al obtener el total a pagar:', error);
        alert('Error al obtener los datos de pago: ' + error);
    });
}
    function showOtherBanks() {
      Swal.fire({
        title: 'Otros Bancos',
        html: `
        <div class="bank-list">
    <button onclick="selectBank('BancoConsorcio')">Banco Consorcio →</button>
    <button onclick="selectBank('BancoInternacional')">Banco Internacional →</button>
    <button onclick="selectBank('BancoItau')">Banco Itaú →</button>
    <button onclick="selectBank('BancoSecurity')">Banco Security →</button>
    <button onclick="selectBank('BancodeChileEdwardsCiti')">Banco de Chile | Edwards | Citi →</button>
    <button onclick="selectBank('CajalosAndes')">Caja los Andes →</button>
    <button onclick="selectBank('Coopeuch')">Coopeuch →</button>
    <button onclick="selectBank('Corpbanca')">Corpbanca →</button>
    <button onclick="selectBank('HSBC')">HSBC →</button>
    <button onclick="selectBank('MercadoPago')">Mercado Pago →</button>
    <button onclick="selectBank('Otrobanco')">Otro banco →</button>
    <button onclick="selectBank('PrepagoLosHeroes')">Prepago Los Heroes →</button>
    <button onclick="selectBank('Scotiabank')">Scotiabank →</button>
    <button onclick="selectBank('Tenpo')">Tenpo →</button>
</div>`,
        preConfirm: () => {
          const selectedBank = document.getElementById('bank-select').value;
          if (!selectedBank) {
            Swal.showValidationMessage("Por favor selecciona un banco"); // Muestra un mensaje si no selecciona banco
            return false;
          }
          return selectedBank;
        },
        confirmButtonText: 'Continuar',
        showCancelButton: true,
        cancelButtonText: 'Volver',
        cancelButtonColor: '#565656',
        customClass: {
          popup: 'custom-swal-popup',
          confirmButtonText: 'custom-confirm-button'
        },
        reverseButtons: true,
      }).then((result) => {
        if (result.isConfirmed && result.value) {
        

          selectBank(result.value);
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          pay(); // Volver a la selección inicial de bancos
        }
      });
    }

    function selectBank(bank) {
      const bankLogoUrl = getBankLogoUrl(bank);
      Swal.fire({
        title: 'Confirmación del Banco',
        html: `
            <img src="${bankLogoUrl}" alt="${bank}" style="width: 100px; height: auto; margin-bottom: 20px;">
            <p>Por favor, ingresa tu RUT para continuar.</p>
            <input type="text" id="rut-input" class="swal2-input" placeholder="Ingresa tu RUT">
            <div id="rut-validation-message" style="color: red; font-size:12px;"></div>
            
        `,
        preConfirm: () => {
          const rut = document.getElementById('rut-input').value;
          if (!validateRUT(rut)) {
            Swal.showValidationMessage("Por favor, ingresa un RUT válido");
            return false;
          }
          return { bank: bank, rut: rut };
        },
        confirmButtonText: 'Continuar',
        showCancelButton: true,
        cancelButtonText: 'Cambiar de banco',
        allowOutsideClick : false,
        customClass: {
          popup: 'custom-swal-popup',
          confirmButton: 'custom-confirm-button'

        },
        didOpen: () => {
          const rutInput = document.getElementById('rut-input');
          rutInput.addEventListener('input', function () {
            this.value = formatRUT(this.value);
          });
          rutInput.addEventListener('blur', function () {
            const isValid = validateRUT(this.value);
            const messageElement = document.getElementById('rut-validation-message');
            messageElement.textContent = isValid ? '' : 'RUT inválido';
          });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          showBankDetails(result.value.bank, result.value.rut);
        } else {
          pay();
        }
      });
    }

    function formatRUT(rut) {
      const cleaned = rut.replace(/[^0-9kK]+/g, ''); // Elimina cualquier carácter que no sea dígito o 'k' o 'K'.
      if (cleaned.length <= 1) return cleaned;

      let body = cleaned.slice(0, -1);
      let dv = cleaned.substr(-1).toUpperCase();

      const formatted = body.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

      return `${formatted}-${dv}`;
    }

    function validateRUT(rut) {
      if (!/^\d{1,3}\.?\d{3}\.?\d{3}-[\dkK]$/.test(rut)) return false;
      let [body, dv] = rut.split('-');
      body = body.replace(/\./g, '');

      let sum = 0;
      let multiplier = 2;
      for (let i = body.length - 1; i >= 0; i--) {
        sum = sum + multiplier * body.charAt(i);
        multiplier = (multiplier == 7) ? 2 : multiplier + 1;
      }
      let calculatedDV = 11 - (sum % 11);
      if (calculatedDV === 11) calculatedDV = '0';
      if (calculatedDV === 10) calculatedDV = 'K';
      return dv.toUpperCase() === calculatedDV.toString().toUpperCase();
    }


    function showBankDetails(bank, rut) {
      const details = {
        accountNumber: '46328157',  // Número de cuenta fijo
        accountHolder: 'Respaldos Chile Spa',  // Titular de la cuenta fijo
        rut: '77186031-1',
        banco: 'Bci',
        tipo: 'Corriente',
        email: 'respaldos.transferencias@gmail.com'  // Email de contacto fijo
      };
      const bankLogoUrl = getBankLogoUrl('BCI'); // Obtener la URL del logo del banco
      let total_porpagar = document.getElementById('totalAPagar').textContent;
      Swal.fire({
        title: 'Transfiere tu pago',
        html: `<strong style="font-size:12px;">Copia los datos de nuestra cuenta de destino, abre la aplicación de tu banco y realiza la transferencia.</strong><div><img src="${bankLogoUrl}" alt="${bank}" style="width: 100px; height: auto; "><div  style="margin-bottom: 15px;">Monto: <strong id="montoapagar">$${total_porpagar}</strong></div></div>
          <div><strong>Banco:</strong> ${details.banco}</div>
            <div><strong>Nombre:</strong> ${details.accountHolder}</div>
            <div><strong>Rut:</strong> ${details.rut}</div>            
            <div><strong>Numero de cuenta:</strong> ${details.accountNumber}</div>  
            <div><strong>Tipo de cuenta:</strong> ${details.tipo}</div>        
            <div><strong>Email:</strong> ${details.email}</div>
            </div>`,
        showCancelButton: true,
        confirmButtonText: 'Ya Transferí',
        cancelButtonText: 'Cambiaré de banco',
        confirmButtonColor: '#68C802',
        allowOutsideClick : false,
        footer: `<button id="copy-button" onclick="copyBankDetails('${details.accountHolder}','${details.rut}', '${details.accountNumber}', '${details.tipo}', '${details.banco}', '${details.email}')">Copiar Datos</button>`,
        customClass: {
          popup: 'custom-swal-popup'        
        }
      }).then((result) => {
        if (result.isConfirmed) {
          confirmTransfer(bank, rut);  // Envía el banco elegido y rut para validación
        } else {
          pay();  // Vuelve a la selección de banco si decide cambiar
        }
      });
    }

    function copyBankDetails(accountHolder,rut, accountNumber, tipo, bank, email) {
      const textToCopy = `Nombre: ${accountHolder}, Rut: ${rut}, N° de cuenta: ${accountNumber}, Tipo de cuenta: ${tipo}, Banco: ${bank}, Email: ${email}`;
      navigator.clipboard.writeText(textToCopy).then(() => {
        Swal.update({
          title: 'Datos copiados',
          html: '<p>Los datos de la cuenta han sido copiados al portapapeles.</p>',
          showConfirmButton: false
          
        });

        // Asume que esta función calcula el monto a pagar

        // Restaurar el contenido original después de 2 segundos
        setTimeout(() => {
          showBankDetails(bank, rut);
        }, 1500);
      }).catch(err => {
        Swal.fire('Error', 'No se pudo copiar los datos.', 'error');
      });
    }


    function cleanCurrency(currencyValue) {
    if (!currencyValue) return 0;
    const cleaned = currencyValue.replace(/\$/g, '').replace(/\./g, '').replace(/,/g, '');
    return parseFloat(cleaned) || 0;
}

let attemptCount = 0;
    function confirmTransfer(bank, rut) {
  Swal.fire({
    title: 'Validando transferencia...',
    html: `
        <div id="swal-content">Por favor espera mientras validamos la transferencia.</div>
        <div style="margin-top: 20px;">
            <div id="progress-bar" style="width: 100%; background: #eee; border-radius: 5px; overflow: hidden;">
                <div id="progress" style="width: 0%; height: 10px; background: #28a745; transition: width 0.1s;"></div>
            </div>
        </div>
    `,
    allowOutsideClick: false,
    customClass: {
      popup: 'custom-swal-popup'
    },
    didOpen: () => {
      Swal.showLoading();
      const progressBar = document.getElementById('progress');
      let progress = 0;
      const interval = setInterval(() => {
        progress += 2;
        if (progress <= 100) {
          progressBar.style.width = progress + '%';
        }
      }, 450);

      // Actualizar mensajes de estado cada cierto tiempo
      setTimeout(() => updateSwalMessage('Estamos procesando tu solicitud...'), 5000);
      setTimeout(() => updateSwalMessage('Casi listo, estamos finalizando la validación...'), 11000);
      setTimeout(() => updateSwalMessage('Gracias por comprar en RespaldosChile...'), 15000);

      $.ajax({
        url: 'validacion_transferencia.php',
        type: 'POST',
        data: { bank, rut, opcion: 'validacion', num_orden: <?php echo $_GET['id']; ?>},
        success: function (response) {
            clearInterval(interval);  // Detener la barra de progreso
            if (response.ok) {
               // Actualizar datatable de pagos
            fetchTotalPrice(response.data.num_orden)
                .then(() => {
                    const totalPagado = cleanCurrency(document.getElementById('total_pagado').textContent);
                    const totalPrecio = cleanCurrency(document.getElementById('precio_total').textContent);
                    console.log('Total pagado:', totalPagado, 'Total precio:', totalPrecio);
                    updatePaymentButton(totalPrecio, totalPagado);  // Actualizar el botón de pago
                })
                .catch(error => console.error('Error updating payment info and prices:', error));
                fetchPaymentInfo(response.data.num_orden);
              const montoRecienteStr = response.data.monto;
    let totalPagadoStr = document.getElementById('total_pagado').textContent;
    let totalAPagarStr = document.getElementById('totalAPagar').textContent;

    let montoReciente = cleanCurrency(montoRecienteStr);
    let totalPagado = cleanCurrency(totalPagadoStr);
    let totalAPagar = cleanCurrency(totalAPagarStr);
                totalPagado += montoReciente;

              
                if (totalPagado >= totalAPagar) {
                  Swal.fire({
    title: '¡Todo listo!',
    html: `
        <div style="font-size: 16px;">¡Los pagos han sido completados con éxito!</div>
        <div style="margin-top: 20px; font-size: 16px; background: #f8f9fa; border-left: 5px solid #28a745; padding: 10px;">
            <strong>Detalles de la Transferencia:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li><strong>Banco:</strong> ${response.data.banco}</li>
                <li><strong>Monto:</strong> ${response.data.monto}</li>
                <li><strong>Rut:</strong> ${response.data.rut}</li>
            </ul>
        </div>
    `,
    icon: 'success',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Aceptar',
    customClass: {
      popup: 'custom-swal-popup',
        confirmButton: 'custom-confirm-button'
    }
});
} else {
   // Actualizar datatable de pagos
fetchPaymentInfo(response.data.num_orden);
    let textoAdicional = response.ok ? "Tu transferencia ha sido registrada, pero no cubre el total requerido." : "Por favor, revisa los detalles de la transferencia enviada.";
    Swal.fire({
    title: '¡Casi listo!',
    html: `
        <p style="font-size: 16px;">${textoAdicional}</p>
        <p style="font-size: 16px; margin-top: 10px;">Por favor, completa el pago restante para finalizar completamente tu transacción.</p>
        <div style="margin-top: 20px; font-size: 16px; background: #f8f9fa; border-left: 5px solid #ffc107; padding: 10px;">
            <strong>Detalles de la Transferencia:</strong>
            <ul style="list-style-type: none; padding-left: 0;">
                <li><strong>Banco:</strong> ${response.data.banco}</li>
                <li><strong>Monto:</strong> ${response.data.monto}</li>
                <li><strong>Rut:</strong> ${response.data.rut}</li>
            </ul>
        </div>
    `,
    icon: 'warning',
    confirmButtonText: 'Continuar',
  
    customClass: {
      popup: 'custom-swal-popup',
        confirmButton: 'custom-confirm-button',

    },
    }).then((result) => {
        if (result.isConfirmed) {
            pay(); // Reabre la ventana de selección de banco para nuevo pago
        }
    });
}

              
            } else {
              if (response.message === "Validación fallida: No se encontraron datos.") {
                if (attemptCount < 1) {
                    Swal.fire({
                        title: 'No se encontraron datos',
                        html: `El RUT ingresado es <strong>${rut}</strong>. Asegúrate de haber realizado la transferencia correctamente.<br><span style='font-size: 12px;  margin-top: 10px;'>Este mensaje puede aparecer si estamos experimentando demoras temporales en recibir la confirmación del banco o si aún no se ha completado la transferencia.</span>`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Reintentar',
                        cancelButtonText: 'Cancelar',
                        customClass: {
                          popup: 'custom-swal-popup',
                            confirmButton: 'custom-confirm-button',
                            cancelButton: 'custom-cancel-button'
                        }
                    }).then((retryResult) => {
                        if (retryResult.isConfirmed) {
                            attemptCount++; // Incrementar el contador de intentos
                            confirmTransfer(bank, rut); // Reintentar la validación
                        } else {
                          pay();
                        }
                    });
                } else {
                    showContactSupportMessage();
                }
            } else {
                Swal.fire('Error', response.message, 'error');
            }
              
            }
        },
        error: function () {
            clearInterval(interval);
            Swal.fire('Error de red', 'Hubo un problema al contactar al servidor. Por favor, intenta nuevamente.', 'error');
        }
      });
    }
  });
}

function showContactSupportMessage() {
    Swal.fire({
        title: 'Limite de Intentos',
        html: `Si el problema persiste, por favor contacta a tu ejecutivo de ventas para asistencia técnica. Esto puede deberse a un problema intermitente en nuestros servidores o a una interrupción de la red. <br><br> Teléfono: <strong>+56979941253</strong>`,
        icon: 'info',
        confirmButtonText: 'Entendido',
        customClass: {
          popup: 'custom-swal-popup',
            confirmButton: 'custom-confirm-button'
        }
    });
}


function updateSwalMessage(message) {
  const swalContent = document.getElementById('swal-content');
  if (swalContent) {
    swalContent.innerHTML = message;
  }
}




function payByWebpay() {
    const totalAPagar = document.getElementById('totalAPagar').textContent;
    document.getElementById('webpaynum_orden').value = <?php echo $id; ?>;
// Establece el monto a pagar
    document.getElementById('amountInput').value = totalAPagar; // Establece el monto a pagar
    document.getElementById('webpayForm').submit(); // Envía el formulario
}





    function getBankLogoUrl(bank) {
      switch (bank) {
        case 'BancoEstado':
          return '<?= media() ?>/images/banc/2024212162213BancoEstado_General_MDP_022024.png';
        case 'BancoDeChile':
          return '<?= media() ?>/images/banc/2022102513251120211021151441BancoDeChile.png';
        case 'BancoSantander':
          return '<?= media() ?>/images/banc/20211021152820santander.png';
        case 'BCI':
          return '<?= media() ?>/images/banc/202421216201520230413123142MedioPagoBCI.png';
        case 'BancoItau':
          return '<?= media() ?>/images/banc/202351818232020211021152053Itau.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoFalabella':
          return '<?= media() ?>/images/banc/202415224744BancoFalabella.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoSecurity':
          return '<?= media() ?>/images/banc/Logo_empresa_banco_security.png'; // Ruta de ejemplo, debes verificarla
        case 'Scotiabank':
          return '<?= media() ?>/images/banc/2023779531820223910154scotiabank_logo_Mesa de trabajo 1.png'; // Ruta de ejemplo, debes verificarla
        case 'Corpbanca':
          return '<?= media() ?>/images/banc/Logo_CorpBanca.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoBice':
          return '<?= media() ?>/images/banc/bice.png'; // Ruta de ejemplo, debes verificarla
        case 'BancoConsorcio':
          return '<?= media() ?>/images/banc/consorcio.jpeg'; // Ruta de ejemplo, debes verificarla
        case 'BancoInternacional':
          return '<?= media() ?>/images/banc/Banco_Internacional_2015.webp'; // Ruta de ejemplo, debes verificarla
        case 'BancoRipley':
          return '<?= media() ?>/images/banc/Logo_Ripley_banco_2.png'; // Ruta de ejemplo, debes verificarla
        case 'HSBC':
          return '<?= media() ?>/images/banc/HSBC-logo.svg'; // Ruta de ejemplo, debes verificarla
        case 'Coopeuch':
          return '<?= media() ?>/images/banc/logo.png'; // Ruta de ejemplo, debes verificarla
        case 'PrepagoLosHeroes':
          return '<?= media() ?>/images/banc/Logo-Los-Heroes-Prepago-3.png'; // Ruta de ejemplo, debes verificarla
        case 'Tenpo':
          return '<?= media() ?>/images/banc/Logo-Tenpo-4.png'; // Ruta de ejemplo, debes verificarla
        case 'CajalosAndes':
          return '<? media() ?>/images/banc/Logotipo_Caja_Los_Andes.png'; 
        case 'Mach':
          return '<?= media() ?>/images/banc/mach-sf.svg'; // Ruta de ejemplo, debes verificarla
        case 'MercadoPago':
          return '<?= media() ?>/images/banc/mercadopago.svg'; // Ruta de ejemplo, debes verificarla
        case 'Otro banco':
          return '<?= media() ?>/images/banc/otrobanco.png'; // Ruta de ejemplo, debes verificarla
        default:
          return '<?= media() ?>/images/banc/default.png'; // Un logo por defecto en caso de que no haya uno específico
      }
    }

    const bankUrls = {
      "BancoSantander": "https://www.santander.cl/",
      "BancodeChile | Edwards | Citi": "https://login.bancochile.cl/bancochile-web/persona/login/index.html#/login",
      "BCI": "https://www.bci.cl/personas",
      "BancoEstado": "https://www.bancoestado.cl/imagenes/comun2008/nuevo_paglg_pers2.html",
      "BancoItau": "https://banco.itau.cl/wps/portal/olb/web/login/!ut/p/b1/04_SjzQxMzY3NTExMteP0I_KSyzLTE8syczPS8wB8aPM4k3dQ40tPQ2BCoxMLQ0cvY0MvZx8fIwDfc2ACiKBCgxwAEcDQvrD9aPwKnE0gSrAY4WfR35uqn5uVI6lp66jIgBeuFZr/dl4/d5/L2dBISEvZ0FBIS9nQSEh/",
      "BancoFalabella": "https://www.bancofalabella.cl/BancoFalabellaChile/index.html",
      "BancoSecurity": "https://www.bancosecurity.cl/widgets/wPersonasLogin/index.asp",
      "Scotiabank": "https://www.scotiabank.cl/login/personas/?nocache=true&_ga=2.149632118.197575516.1504294443-831341108.1504294443",
      "Corpbanca": "https://www.corpbanca.cl/Ibank/Login.aspx?Persona",
      "BancoBICE": "http://www.bice.cl/personas",
      "BancoConsorcio": "https://www.bancoconsorcio.cl/WEB_BANCO_TRX/login.aspx",
      "BancoInternacional": "https://www.bancointernacional.cl/index.aspx",
      "BancoRipley": "https://miportal.bancoripley.cl/home/login.handler",
      "HSBC": "http://www.hsbc.cl/",
      "Coopeuch": "https://www.coopeuch.cl/tef/#/",
      "Prepago Los Heroes": "https://sitioprivado.prepagolosheroes.cl/login",
      "Tenpo": "https://www.tenpo.cl/",
      "CajalosAndes": "https://www.cajalosandes.cl/home_personas",
      "MercadoPago": "https://www.mercadopago.cl/link-de-pago-plugins-y-plataformas-checkout?matt_tool=70038000&matt_word=MLC_Institucionales_B&gclid=CjwKCAiA68ebBhB-EiwALVC-No2c5ZBw2F0Db1SUxxSgApcfPD8-XdhYp6kynLeMA_6X7VsFqklnRRoC_RAQAvD_BwE",
      "Otro banco": "N/A"  // Supongo que es un placeholder y deberías manejarlo en el código.
    };





  