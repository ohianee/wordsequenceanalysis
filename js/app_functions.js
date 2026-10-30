/**
 * @file app_functions.js
 * @brief Funciones de JavaScript para la aplicación.
 * 
 * Este archivo contiene funciones de JavaScript que se utilizan en la aplicación.
 * 
 * @author Naiara Gordillo
 */

/**
 * @brief Invoca los scripts de un elemento HTML.
 * 
 * Esta función recorre los scripts de un elemento HTML y los ejecuta.
 * 
 * @param {HTMLElement} divid - Elemento HTML que contiene los scripts a ejecutar.
 * 
 * @return {void}
 */
function invokeScript(divid) {
    var scriptObj = divid.getElementsByTagName("SCRIPT");
    var len = scriptObj.length;

    for (var i = 0; i < len; i++) {
        var scriptText = scriptObj[i].text;
        var scriptFile = scriptObj[i].src;
        var scriptTag = document.createElement("SCRIPT");

        if (scriptFile != null && scriptFile !== "") {
            scriptTag.src = scriptFile;
        }
        scriptTag.text = scriptText;
        if (!document.getElementsByTagName("HEAD")[0]) {
            document.createElement("HEAD").appendChild(scriptTag);
        } else {
            document.getElementsByTagName("HEAD")[0].appendChild(scriptTag);
        }
    }
}

/** 
 * @brief Crea una nueva conexión XMLHttpRequest.
 * 
 * Esta función crea y devuelve un nuevo objeto XMLHttpRequest que se puede utilizar 
 * para hacer solicitudes HTTP.
 * 
 * @return {XMLHttpRequest} - Objeto XMLHttpRequest.
 */
function nuevaConexion() {
    var xmlhttp = false;

    try {
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
        try {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (E) {
            xmlhttp = false;
        }
    }

    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

/** 
 * @brief Carga una página en un elemento HTML.
 * 
 * Esta función realiza una solicitud GET a una URL especificada y carga la respuesta 
 * en un elemento HTML dado.
 * 
 * @param {string} url - URL de la página a cargar.
 * @param {string} capa - ID del elemento HTML donde se cargará la página.
 * @param {boolean} pushState - Indica si se debe añadir una entrada al historial del navegador (por defecto, true).
 * 
 * @return {void}
 */
function Cargar(url, capa, pushState) {
    if (typeof pushState === 'undefined') {
        pushState = true;
    }
    var contenido = document.getElementById(capa);
    var conexion = nuevaConexion();

    conexion.open("GET", url, true);
    conexion.onreadystatechange = function() {
        if (conexion.readyState == 4 && conexion.status == 200) {
            contenido.innerHTML = conexion.responseText;
            invokeScript(document.getElementById(capa));

            if (pushState) {
                history.pushState({url: url, capa: capa}, '', url);
            }
        }
    };
    conexion.send(null);
}

/** 
 * @brief Maneja eventos de historial al navegar hacia atrás o adelante en el navegador.
 * 
 * Esta función se activa cuando se detecta un evento de 'popstate' y carga la página correspondiente al 
 * estado guardado en el historial.
 * 
 * @return {void}
 */
window.addEventListener('popstate', function(event) {
    if (event.state) {
        Cargar(event.state.url, event.state.capa, false);
    }
});

/**
 * @brief Procesa un formulario y envía los datos a un script PHP.
 * 
 * Esta función recoge los datos de un formulario HTML y los envía mediante una solicitud POST 
 * a un script PHP especificado.
 * 
 * @param {HTMLFormElement} formulario - Formulario a procesar.
 * @param {string} url - URL del script PHP al que se enviarán los datos.
 * @param {string} capa - ID del elemento HTML donde se mostrará la respuesta del servidor.
 * 
 * @return {void}
 */
function ProcesarForm(formulario, url, capa) {
    var formData = new FormData(formulario);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);

    xhr.onload = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById(capa).innerHTML = xhr.responseText;
        } else {
            console.error('Error: ' + xhr.status);
        }
    };

    xhr.send(formData);
}

/**
 * @brief Oculta varios modales.
 * 
 * Esta función oculta todos los modales especificados en la aplicación.
 * 
 * @return {void}
 */
function ocultarModal() {
    var modal = document.getElementById('passwordModal');
    modal.style.display = 'none';
    var modalConfirm = document.getElementById('confirmModal');
    modalConfirm.style.display = 'none';
    var modalSession = document.getElementById('loginModal');
    modalSession.style.display = 'none';
    var modalAdd = document.getElementById('addTableModal');
    modalAdd.style.display = 'none';
    var modalDelete = document.getElementById('deleteTableModal');
    modalDelete.style.display = 'none';

    var modalBackdrop = document.querySelector('.modal-backdrop');
    if (modalBackdrop) {
        modalBackdrop.parentNode.removeChild(modalBackdrop);
    }

    document.body.style.paddingRight = '';
    document.body.style.overflow = '';

    closeNavbar();
}

/**
 * @brief Cierra el menú de navegación.
 * 
 * Esta función oculta el menú de navegación colapsable de la interfaz de usuario.
 * 
 * @return {void}
 */
function closeNavbar() {
    var navbarCollapse = document.querySelector('#collapsibleNavbar');
    var bsCollapse = new bootstrap.Collapse(navbarCollapse, {
        toggle: false
    });
    bsCollapse.hide();
}

/**
 * @brief Muestra u oculta el botón de confirmación.
 * 
 * Esta función muestra el botón de confirmar si el estado es verdadero, y lo oculta si es falso.
 * 
 * @param {boolean} estado - Indica si se debe mostrar o ocultar el botón de confirmar.
 * 
 * @return {void}
 */ 
function controlarBotonConfirmar(estado) {
    var btnConfirmar = document.getElementById('btnConfirmar');
    if (estado) {
        btnConfirmar.style.display = 'inline-block';
    } else {
        btnConfirmar.style.display = 'none';
    }
}

/**
 * @brief Muestra un modal para actualizar la base de datos y procesa la actualización.
 * 
 * Esta función envía los datos del formulario de actualización a un script PHP y maneja la respuesta.
 * 
 * @param {Event} event - Evento que se desencadena al enviar el formulario.
 * 
 * @return {void}
 */
function actualizarBD(event) {
    event.preventDefault();
    document.getElementById('actualizandoMensaje').style.display = 'block';
    const form = document.getElementById('updateForm');
    const formData = new FormData(form);
    
    // Registrar el tiempo de inicio
    const startTime = new Date().getTime();

    fetch(appDir + '/control/update_bd.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Raw response:', response);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            
            // Registrar el tiempo de finalización
            const endTime = new Date().getTime();
            const timeTaken = (endTime - startTime) / 1000; // Convertir a segundos
            console.log(`Tiempo de actualización: ${timeTaken} segundos`);

            if (data.success) {
                alert(`${data.message} (Tiempo: ${timeTaken} segundos)`);
                ocultarModal();
                Cargar(appDir + '/view/home.php', 'contenido');
                checkSession();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
            alert('Ocurrió un error al actualizar la base de datos.');
        } finally {
            document.getElementById('actualizandoMensaje').style.display = 'none';
            controlarBotonConfirmar(true);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurrió un error al actualizar la base de datos.');
        document.getElementById('actualizandoMensaje').style.display = 'none';
    });
}

/**
 * @brief Muestra un modal para confirmar la actualización de la base de datos y procesa la confirmación.
 * 
 * Esta función envía los datos de confirmación a un script PHP y maneja la respuesta.
 * 
 * @param {Event} event - Evento que se desencadena al enviar el formulario de confirmación.
 * 
 * @return {void}
 */
function confirmarBD(event) {
    event.preventDefault();
    const form = document.getElementById('confirmForm');
    const formData = new FormData(form);

    fetch(appDir + '/control/confirm_update.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Raw response:', response);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alert(data.message);
                ocultarModal();
                Cargar(appDir + '/view/home.php', 'contenido');
                checkSession();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
            alert('Ocurri&oacute; un error al confirmar la actualizaci&oacute;n.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurri&oacute; un error al confirmar la actualizaci&oacute;n.');
    });
}

/**
 * @brief Verifica la sesión del usuario.
 * 
 * Esta función realiza una solicitud para comprobar si el usuario está autenticado 
 * y actualiza la interfaz de usuario en consecuencia.
 * 
 * @return {void}
 */
function checkSession() {
    fetch(appDir + '/control/check_session.php')
        .then(response => response.json())
        .then(data => {
            if (data.loggedin) {
                document.getElementById('dropdownMenuButton').style.display = 'block';
                document.getElementById('btnSession').style.display = 'none';
            } else {
                document.getElementById('dropdownMenuButton').style.display = 'none';
                document.getElementById('btnSession').style.display = 'inline-block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

/**
 * @brief Inicia sesión en la aplicación.
 * 
 * Esta función maneja el evento de envío del formulario de inicio de sesión,
 * envía los datos a un script PHP y gestiona la respuesta para autenticar al usuario.
 * 
 * @param {Event} event - Evento que se desencadena al enviar el formulario de inicio de sesión.
 * 
 * @return {void}
 */
function iniciarSesion(event) {
    event.preventDefault();
    const form = document.getElementById('loginForm');
    const formData = new FormData(form);

    fetch(appDir + '/control/login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Raw response:', response);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);

        try {
            const data = JSON.parse(text);
            if (data.success) {
                alert(data.message);
                ocultarModal();
                Cargar(appDir + '/view/home.php', 'contenido');
                checkSession();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
            alert('Ocurri&oacute; un error al iniciar sesi&oacute;n.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurri&oacute; un error al iniciar sesi&oacute;n.');
    });
}

/**
 * @brief Cierra la sesión del usuario.
 * 
 * Esta función envía una solicitud a un script PHP para cerrar la sesión del usuario
 * y maneja la respuesta para actualizar la interfaz de usuario.
 * 
 * @return {void}
 */
function cerrarSesion() {
    fetch(appDir + '/control/logout.php', {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            Cargar(appDir + '/view/home.php', 'contenido');
            checkSession();
            closeNavbar();
        } else {
            alert('Error al cerrar sesi&oacute;n.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurri&oacute; un error al cerrar sesi&oacute;n.');
    });
}

/**
 * @brief Añade una nueva tabla a la base de datos.
 * 
 * Esta función recoge los datos del formulario para añadir una nueva tabla,
 * verifica si la URL proporcionada es válida y, de ser así, envía una solicitud
 * para crear la tabla.
 * 
 * @param {Event} event - Evento que se desencadena al enviar el formulario para añadir una tabla.
 * 
 * @return {void}
 */
function addTable(event) {
    event.preventDefault();
    const tableNameInput = document.getElementById('tableNameInput').value.trim();
    const tableUrlInput = document.getElementById('tableUrlInput').value.trim();

    const tableName = tableNameInput.toLowerCase().replace(/\s+/g, '_');
    const tableUrl = tableUrlInput.endsWith('/') ? tableUrlInput : tableUrlInput + '/';

    const testUrl = `${tableUrl}${tableName}/`;
    fetch(testUrl)
        .then(response => {
            if (response.ok) {
                const formData = new FormData();
                formData.append('tableName', tableName);
                formData.append('tableUrl', tableUrl);

                return fetch(appDir + '/control/add_genome.php', {
                    method: 'POST',
                    body: formData
                });
            } else {
                throw new Error('La URL proporcionada no existe.');
            }
        })
        .then(response => response.text())
        .then(text => {
            console.log('Response text:', text);

            try {
                const data = JSON.parse(text);
                if (data.success) {
                    alert(data.message);
                    ocultarModal();
                    Cargar(appDir + '/view/home.php', 'contenido');
                    checkSession();
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('Error al analizar la respuesta JSON:', error);
                alert('Error al procesar la respuesta del servidor.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ocurri&oacute; un error al a&ntilde;adir la tabla.');
        });
}

/**
 * @brief Elimina una tabla de la base de datos.
 * 
 * Esta función recoge el nombre de la tabla que se desea eliminar y envía una solicitud
 * a un script PHP para realizar la eliminación, gestionando la respuesta del servidor.
 * 
 * @param {Event} event - Evento que se desencadena al enviar el formulario para eliminar una tabla.
 * 
 * @return {void}
 */
function deleteTable(event) {
    event.preventDefault();
    const tableNameInput = document.getElementById('deleteTableNameInput').value.trim();
    const tableName = tableNameInput.toLowerCase().replace(/\s+/g, '_');
    const formData = new FormData();
    formData.append('tableName', tableName);

    fetch(appDir + '/control/delete_genome.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        console.log('Response text:', text);
        try {
            const data = JSON.parse(text);
            if (data.success) {
                alert(data.message);
                ocultarModal();
                Cargar(appDir + '/view/home.php', 'contenido');
                checkSession();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
            alert('Ocurri&oacute; un error al procesar la respuesta.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ocurri&oacute; un error al eliminar la tabla.');
    });
}

/**
 * @brief Muestra un indicador de carga en la interfaz de usuario.
 * 
 * Esta función cambia el estilo del elemento con ID 'carga' para mostrar un
 * indicador de carga visual (ej. un spinner o una barra de progreso).
 * 
 * @return {void}
 */
function mostrarCarga() {
    document.getElementById('carga').style.display = 'flex';
}