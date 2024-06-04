// Función para establecer una cookie
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

// Función para obtener una cookie
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) === ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Función para borrar una cookie
function eraseCookie(name) {
    document.cookie = name + '=; Max-Age=-99999999;';
}

// Mostrar el aviso de cookies si no está aceptado
function checkCookieConsent() {
    if (!getCookie('cookieConsent')) {
        document.getElementById('cookieConsentContainer').style.display = 'block';
    }
}

// Aceptar cookies
function acceptCookies() {
    setCookie('cookieConsent', 'accepted', 1); // 1 día de duración
    document.getElementById('cookieConsentContainer').style.display = 'none';
}

// Rechazar cookies
function rejectCookies() {
    eraseCookie('cookieConsent');
    document.getElementById('cookieConsentContainer').style.display = 'none';
}

// Ejecutar la comprobación de cookies cuando se carga la página
window.onload = checkCookieConsent;
