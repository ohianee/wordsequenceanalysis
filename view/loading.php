<?php
    namespace view;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading</title>
    
    <script>
        /**
         * Animación de los círculos (.animate) en el SVG.
         * Esta función selecciona todos los elementos con la clase 'animate', toma su radio
         * y lo anima para aumentar su tamaño temporalmente y volver a su tamaño original.
         */
        document.querySelectorAll('.animate').forEach(circle => {
            const originalRadius = parseFloat(circle.getAttribute('r')); // Obtiene el radio original
            const animatedRadius = originalRadius * 1.3; // Define el radio animado (30% mayor)
            
            // Inicia la animación: aumenta el radio, lo reduce, y repite indefinidamente.
            circle.animate([
            { r: originalRadius },
            { r: animatedRadius },
            { r: originalRadius }
            ], {
                duration: 1500, // Duración de la animación en milisegundos
                iterations: Infinity, // La animación se repite indefinidamente
                easing: 'ease-in-out', // La animación es suave, acelera y desacelera
                fill: 'forwards' // La animación mantiene su estado final
            });
        });
        
        /**
         * Aplica un retraso en la animación de cada línea para que las animaciones no
         * inicien al mismo tiempo, creando un efecto visual escalonado.
         */
        document.querySelectorAll('.animate-line').forEach((line, index) => {
            line.style.animationDelay = `${index * 0.3}s`; // Retraso basado en el índice
        });
        
        /**
         * Aplica un retraso similar en la animación de los círculos (.animate).
         * El efecto es el mismo que con las líneas, pero para los círculos.
         */
        document.querySelectorAll('.animate').forEach((circle, index) => {
            circle.style.animationDelay = `${index * 0.3}s`; // Retraso escalonado
        });
    </script>
</head>
<body>
    <!-- SVG que contiene líneas y círculos animados -->
    <svg width="200" height="350" viewBox="-20 0 180 160" xmlns="http://www.w3.org/2000/svg">
        <!-- Definición de un gradiente de color utilizado en las líneas y círculos -->
        <defs>
            <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#ff66c4;stop-opacity:1" /> <!-- Color inicial del gradiente -->
                <stop offset="100%" style="stop-color:#082b3e;stop-opacity:1" /> <!-- Color final del gradiente -->
            </linearGradient>
        </defs>

        <!-- Definición de las líneas animadas del SVG -->
        <line x1="40" y1="70" x2="40.05" y2="120" stroke="url(#grad1)" stroke-width="2" class="animate-line"/>
        <line x1="40" y1="70" x2="80" y2="30" stroke="url(#grad1)" stroke-width="2" class="animate-line"/>
        <line x1="80" y1="30" x2="100" y2="70" stroke="url(#grad1)" stroke-width="2" class="animate-line"/>
        <line x1="100" y1="70" x2="80" y2="100" stroke="url(#grad1)" stroke-width="2" class="animate-line"/>
        <line x1="80" y1="100" x2="130" y2="120" stroke="url(#grad1)" stroke-width="2" class="animate-line"/>
        <line x1="100" y1="70" x2="140" y2="70.05" stroke="url(#grad1)" stroke-width="2" class="animate-line"/>
        <line x1="140" y1="70" x2="130" y2="10" stroke="url(#grad1)" stroke-width="2" class="animate-line"/>

        <!-- Definición de los círculos animados del SVG -->
        <circle cx="40" cy="70" r="25" fill="url(#grad1)" class="animate" />
        <circle cx="40" cy="120" r="5" fill="url(#grad1)" class="animate" />
        <circle cx="80" cy="30" r="15" fill="url(#grad1)" class="animate" />
        <circle cx="100" cy="70" r="8" fill="url(#grad1)" class="animate" />
        <circle cx="80" cy="100" r="15" fill="url(#grad1)" class="animate" />
        <circle cx="130" cy="120" r="10" fill="url(#grad1)" class="animate" />
        <circle cx="140" cy="70" r="15" fill="url(#grad1)" class="animate" />
        <circle cx="130" cy="10" r="5" fill="url(#grad1)" class="animate" />
    </svg>
</body>
</html>