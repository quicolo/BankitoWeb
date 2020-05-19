<?php
require_once '../resources/config.php';
include TEMPLATES_PATH . '/index-header.php';
include LIBRARY_PATH . '/maneja-sesion.php';

iniciaSesionSegura();
?>

<div class="w3-center w3-padding-64" id="version-basica">
    <span class="w3-xlarge w3-bottombar w3-border-dark-grey w3-padding-16">Versión básica</span>
    <h4 class="w3-padding-16"><i>Un punto de comienzo sencillo pero funcional</i></h4>
</div>
<div class="w3-container">
    <p>A continuación se detallan los elementos de la <b>versión básica</b> de Bankito y la 
    descripción de cada uno de ellos.</p>
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-indigo w3-padding-16">
            <i class="fas fa-palette fa-2x"></i><span class="w3-xlarge w3-margin-left"> Interfaz gráfica</span>
        </header>
        <div class="w3-container">
            <p>Desarrollada en HTML/CSS, haciendo <b>uso del framework  
            <a href="https://www.w3schools.com/w3css/default.asp">W3.CSS</a></b>, creado en <a href="https://www.w3schools.com/">w3schools</a></p>
            <p>W3.CSS es un framework CSS adaptativo (responsive), ligero, rápido, fácil de aprender y con una documentación excelente.</p>
            
        </div>
    </div>
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-violet w3-padding-16">
            <i class="fas fa-diagnoses fa-2x"></i><span class="w3-xlarge w3-margin-left"> Experiencia de usuario</span>
        </header>
        <div class="w3-container">
            <p>Desarrollada con muy <b>poco Javascript y sin llamadas Ajax</b>, la experiencia de usuario de
            esta versión es bastante plana y predecible.</p>            
        </div>
    </div>
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-magenta w3-padding-16">
            <i class="fas fa-spell-check fa-2x"></i><span class="w3-xlarge w3-margin-left"> Semántica de la URL</span>
        </header>
        <div class="w3-container">
            <p>Las URL de esta versión <b>utiliza solo un nivel de carpetas como categorías semánticas</b> por lo que
            no están demasiado optimizadas para buscadores. </p>
            <p>No obstante, se ha procurado que los nombres de las
            distintas páginas sean significativos, se ha utilizado el guión como separador de palabras
            y no se usan parámetros GET que dificulten la lectura de la URL. </p>            
        </div>
    </div>
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-crimson w3-padding-16">
            <i class="fas fa-cubes fa-2x"></i><span class="w3-xlarge w3-margin-left"> Paradigma de programación</span>
        </header>
        <div class="w3-container">
            <p><b>Funcional</b>. Aunque actualmente PHP es multiparadigma (funcional y orientado a objetos), inicialmente 
            seguía un modelo de programación funcional y dispone muchas librerías de funciones que no dependen de objetos
            ni de clases. Por este motivo, nos parece más coherente que la versión básica sea funcional, para incluir
            la orientación a objetos en versiones posteriores.</p>            
        </div>
    </div>
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-red w3-padding-16">
            <i class="fas fa-code fa-2x"></i><span class="w3-xlarge w3-margin-left"> Diseño del código</span>
        </header>
        <div class="w3-container">
            <p>Diseño <b>fuertemente acoplado basado en dos capas</b>: Vista y Modelo. La maquetación de la vista se realiza mediante plantillas muy básicas. 
            El modelo hace uso de una librería propia de funciones de uso frecuente.</p>
            <p>Las variables de entorno y de configuración están en ficheros independientes.</p>
        </div>
    </div>
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-orange w3-padding-16">
            <i class="fas fa-shield-alt fa-2x"></i><span class="w3-xlarge w3-margin-left"> Seguridad</span>
        </header>
        <div class="w3-container">
            <p>Se toman medidas activas para <b>dotar de cierto nivel de seguridad</b> en los siguientes aspectos:</p>
            <ul>
                <li>Se filtran todas las entradas para evitar la inyección de SQL.</li>
                <li>Se filtran todas las entradas para evitar ataques de scripting.</li>
                <li>Se valida el email del usuario en dos pasos.</li>
                <li>Se cifran las contraseñas en la base de datos.</li>
                <li>Las sesiones de usuario caducan por inactividad.</li>
            </ul>
        </div>
    </div>
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-amber w3-padding-16">
            <i class="fas fa-bug fa-2x"></i><span class="w3-xlarge w3-margin-left"> Depuración del código</span>
        </header>
        <div class="w3-container">
            <p><b>Sin herramientas específicas de depuración de código</b>. Solo se utiliza una función que imprime por la consola del navegador
            siempre que la constante de depuración esté activa.</p>
        </div>
    </div>  
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-yellow w3-padding-16">
            <i class="fab fa-git-alt fa-2x"></i><span class="w3-xlarge w3-margin-left"> Control de versiones</span>
        </header>
        <div class="w3-container">
            <p>Uso de <b><a href="https://git-scm.com/">Git</a> como sistema de control de versiones</b> local y distribuído. 
            Conjuntamente se utiliza un repostorio en <b><a href="https://github.com/">GitHub</a> como almacén
            maestro de código</b> y que nos sirve además para el despliegue en el entorno del VPS (Servidor Privado Virtual).</p>
        </div>
    </div> 
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-brown w3-padding-16">
            <i class="fas fa-server fa-2x"></i><span class="w3-xlarge w3-margin-left"> Entornos de ejecución</span>
        </header>
        <div class="w3-container">
            <p>La aplicación puede correr en dos entornos:</p>
            <ul>
                <li><b>Entorno de desarrollo</b>: se basa en la máquina local del desarrollador con un servidor WAMP o similar.</li>
                <li><b>Entorno de producción</b>: se basa en un VPS (Servidor Privado Virtual) con Apache accesible desde Internet.</li>
            </ul>
        </div>
    </div> 
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-olive w3-padding-16">
            <i class="fas fa-expand-arrows-alt fa-2x"></i><span class="w3-xlarge w3-margin-left"> Dependencias externas</span>
        </header>
        <div class="w3-container">
            <p>La aplicación tiene las siguientes dependencias externas:</p>
            <ul>
                <li><b><a href="https://github.com/PHPMailer/PHPMailer">PHPMailer</a></b>: para el envío de emails. Instalado desde el gestor de dependencias <a href="https://getcomposer.org/">Composer</a>.</li>
                <li><b><a href="https://www.w3schools.com/w3css/default.asp">W3.CSS</a></b>: framework adaptativo y de fácil aprendizaje desarrollado por <a href="https://www.w3schools.com/">w3schools</a>.</li>
                <li><b><a href="https://www.mysql.com/">MySQL</a></b>: base de datos de código abierto.</li>
            </ul>
        </div>
    </div> 
    <div class="w3-card-4 w3-margin-bottom">
        <header class="w3-container w3-win8-steel w3-padding-16">
            <i class="far fa-window-restore fa-2x"></i><span class="w3-xlarge w3-margin-left"> Software utilizado para el desarrollo</span>
        </header>
        <div class="w3-container">
            <p>El desarrollo de la aplicación se ha realizado con las siguientes herramientas:</p>
            <ul>
                <li><b><a href="https://code.visualstudio.com/">VS Code</a></b>: IDE ligero open source</li>
                <li><b><a href="https://netbeans.org/">NetBeans</a></b>: IDE open source</li>
                <li><b><a href="http://www.wampserver.com/en/">WAMP Server</a></b>: servidor para Windows de la pila Apache, PHP y MySQL</li>
                <li><b><a href="https://httpd.apache.org/">Apache Server</a></b>: servidor web para Linux</li>
                <li><b><a href="https://git-scm.com/">Git</a></b>: sistema de control de versiones distribuido</li>
                <li><b><a href="https://www.mysql.com/">MySQL</a></b>: base de datos de código abierto.</li>
                <li><b><a href="https://www.mysql.com/products/workbench/">MySQL Workbench</a></b>: gestor de la bases de datos MySQL.</li>
            </ul>
        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . '/index-footer.php';
?>