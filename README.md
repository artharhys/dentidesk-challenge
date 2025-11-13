Resumen de tecnologías <br><br>
-----Backend-----<br>
-Laravel 12.0 (PHP 8.2+)<br>
-MySQL 8.0 / SQLite<br>
-Eloquent ORM<br>
-Patrón MVC<br><br>
-----Frontend-----<br>
-Blade Templates<br>
-Bootstrap 5.3.2 (CDN)<br>
-Chart.js 4.4.0<br>
-Vanilla JavaScript<br><br>
-----DevOps-----<br>
-Docker + Docker Compose<br>
-Laravel Sail<br><br>
-----Patrones-----<br>
-MVC<br>
-Facade Pattern<br>
-Repository Pattern (Eloquent)<br>
-Dependency Injection<br><br>
-----Funcionalidades-----<br>
-CRUD completo<br>
-API REST<br>
-Cálculos de balance y ganancias mensuales<br>
-Gráfico de evolución<br>
-Validación de datos<br>
-Diseño responsive<br><br>

-----Instalación y ejecución-----<br>
<br>
---Requisitos previos<br>
<br>
- PHP 8.2 o superior<br>
- Composer (https://getcomposer.org/download/)<br>
- Docker y Docker Compose<br><br>

---Con Laravel Sail (Docker)<br>
<br>
-Instalar dependencias y configurar<br>
composer run setup <br>
<br>
-Levantar el proyecto <br>
./vendor/bin/sail up -d <br>
<br>
-Ejecutar migraciones <br>
./vendor/bin/sail artisan migrate <br>

<div class="t m0 x1 h1 y1 ff1 fs0 fc0 sc0 ls0 ws0">&quot;Desafío Code Challenge&quot; </div>
<div class="t m0 x2 h2 y2 ff2 fs1 fc0 sc0 ls0 ws0">  </div>
<div class="t m0 x2 h2 y3 ff2 fs1 fc0 sc0 ls0 ws0">  </div>
<div class="t m0 x3 h3 y7 ff3 fs1 fc0 sc0 ls0 ws0">Para <span class="_ _0"> </span>comenzar<span class="_ _1"></span>, <span class="_ _0"> </span>te <span class="_ _0"> </span>queremos <span class="_ _0"> </span>invitar <span class="_ _2"></span>al <span class="_ _2"></span><span class="ff1">&quot;Code <span class="_ _2"></span>Challenge&quot;</span> <span class="_ _2"></span>en <span class="_ _2"></span>donde <span class="_ _2"></span>tendrás <span class="_ _2"></span>que <span class="_ _2"></span>crear <span class="_ _2"></span>un <span class="_ _2"></span>pequeño </div><div class="t m0 x3 h4 y8 ff3 fs1 fc0 sc0 ls0 ws0">proyecto. </div><div class="t m0 x3 h5 y9 ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h4 ya ff3 fs1 fc0 sc0 ls0 ws0">No es necesario implementar todas las funciones ni todos los aspectos de este challenge. </div><div class="t m0 x3 h4 yb ff3 fs1 fc0 sc0 ls0 ws0">Por esto, te invitamos a implementar solo lo que te sientas cómodo haciendo. </div><div class="t m0 x3 h2 yc ff2 fs1 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h4 yd ff3 fs1 fc0 sc0 ls0 ws0">De todas formas, si deseas hacer todo sumas puntos. </div><div class="t m0 x3 h4 ye ff3 fs1 fc0 sc0 ls0 ws0">Además, puedes investigar e intentar hacerlas si no sabes cómo. </div><div class="t m0 x2 h5 yf ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h3 y10 ff1 fs1 fc0 sc0 ls0 ws0">Puntos a evaluar: </div><div class="t m0 x4 h4 y11 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Simplicidad del código (muy importante) </div><div class="t m0 x4 h4 y12 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Claridad al elegir nombres de variables </div><div class="t m0 x4 h4 y13 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Uso de patrones de diseño (facade, singleton, controller<span class="_ _1"></span>, model etc...) </div><div class="t m0 x4 h4 y14 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Manejo de php </div><div class="t m0 x4 h4 y15 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Eficiencia en la solución planteada </div><div class="t m0 x4 h4 y16 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Manejo de React/Blade templates </div><div class="t m0 x4 h4 y17 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>React o Bootstrap </div><div class="t m0 x4 h4 y18 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Uso de git </div><div class="t m0 x4 h4 y19 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Comprensión de los requerimientos </div><div class="t m0 x4 h4 y1a ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>T<span class="_ _1"></span>iempo de entrega </div><div class="t m0 x2 h5 y1b ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h3 y1c ff1 fs1 fc0 sc0 ls0 ws0">Mantenedor de finanzas </div><div class="t m0 x2 h5 y1d ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h4 y1e ff3 fs1 fc0 sc0 ls0 ws0">En este mini proyecto, se requiere implementar un administrador de ingresos y egresos (simple) </div><div class="t m0 x3 h4 y1f ff3 fs1 fc0 sc0 ls0 ws0">y mostrar el total de ganancias para el mes. </div><div class="t m0 x3 h2 y20 ff2 fs1 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h4 y21 ff3 fs1 fc0 sc0 ls0 ws0">Por favor mantener esta aplicación lo más simple posible. </div><div class="t m0 x3 h4 y22 ff3 fs1 fc0 sc0 ls0 ws0">La Simplicidad del código y la solución será evaluada. </div><div class="t m0 x3 h5 y23 ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h3 y24 ff1 fs1 fc0 sc0 ls0 ws0">T<span class="_ _1"></span>ecnologías a usar: </div><div class="t m0 x3 h4 y25 ff3 fs1 fc0 sc0 ls0 ws0">- Php, puede ser puro, nativo o MVC </div><div class="t m0 x3 h4 y26 ff3 fs1 fc0 sc0 ls0 ws0">- Base de datos (a elección) </div><div class="t m0 x3 h4 y27 ff3 fs1 fc0 sc0 ls0 ws0">- Frontend (bootstrap, laravel blade templates o react.js)  </div><div class="t m0 x3 h5 y28 ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x2 h5 y29 ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h3 y2a ff1 fs1 fc0 sc0 ls0 ws0">Backend: </div><div class="t m0 x4 h4 y2b ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Proponer e implementar un modo de almacenamiento de la información (base de datos) </div><div class="t m0 x4 h4 y2c ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Crear REST endpoints para ingreso de transacciones (ingresos y egresos) y cálculos por </div><div class="t m0 x5 h4 y2d ff3 fs1 fc0 sc0 ls0 ws0">mes </div><div class="t m0 x4 h4 y2e ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Guardar la información en la base de datos (CRUD) </div><div class="t m0 x5 h4 y2f ff3 fs1 fc0 sc0 ls0 ws0"> </div><div class="t m0 x3 h5 y30 ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h5 y31 ff2 fs2 fc0 sc0 ls0 ws0"> </div><div class="t m0 x3 h5 y32 ff2 fs2 fc0 sc0 ls0 ws0"> </div></div><div class="pi" data-data='{"ctm":[1.500000,0.000000,0.000000,1.500000,0.000000,0.000000]}'></div></div>
<div class="t m0 x3 h3 y33 ff1 fs1 fc0 sc0 ls0 ws0">Frontend: </div><div class="t m0 x4 h4 y34 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Crear interfaz simple para ingreso de transacciones </div><div class="t m0 x4 h4 y35 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>usar css/sass u algún ui framework. </div><div class="t m0 x4 h4 y36 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Mostrar total ganado en el mes </div><div class="t m0 x4 h4 y37 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>crear formulario para ingreso de transacciones </div><div class="t m0 x4 h4 y38 ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>crear menú para navegar en la aplicación  </div><div class="t m0 x3 h5 y39 ff2 fs2 fc0 sc0 ls0 ws0">  </div><div class="t m0 x3 h3 y3a ff1 fs1 fc0 sc0 ls0 ws0">Devops: </div><div class="t m0 x4 h4 y3b ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>instalar la aplicación como docker container </div><div class="t m0 x4 h4 y3c ff3 fs1 fc0 sc0 ls0 ws0">● <span class="_ _3"> </span>Correr la aplicación bajo docker-compose o swarm o k8s </div><div class="t m0 x3 h5 y3d ff2 fs2 fc0 sc0 ls0 ws0">  </div>
</div>

