-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-07-2026 a las 22:00:30
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `kurpiti`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grafos`
--

CREATE TABLE `grafos` (
  `id` bigint(15) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `grafos`
--

INSERT INTO `grafos` (`id`, `nombre`, `descripcion`) VALUES
(30, 'LA CÉLULA EUCARIOTA', 'Todas las células eucariotas poseen un núcleo. Sin embargo, la presencia de un núcleo va de la mano con la de diversos orgánulos, la mayoría de los cuales están rodeados por membranas y son comunes a todos los organismos eucariotas, pero ausentes en los procariotas.\r\nFuente: nerd.wwnorton.com/ebooks/epub/ecb6/EPUB/content/1.4-chapter01.xhtml'),
(31, 'SARS-CoV-2 (COVID-19)', 'Es un coronavirus de ARN monocatenario positivo, perteneciente a la familia Coronaviridae, responsable de la pandemia de COVID-19 iniciada en 2019. Su estructura incluye una envoltura lipídica con proteínas de superficie, entre ellas la proteína Spike, clave para su capacidad infecciosa. Se transmite principalmente por vía respiratoria mediante gotículas y aerosoles.\r\n\r\nFuentes: Info obtenida de iternet. pmc.ncbi.nlm.nih.gov/articles/PMC7537588'),
(32, 'Software Libre', 'Es un movimiento y filosofía iniciado por Richard Stallman en 1983, basado en cuatro libertades esenciales: usar el programa con cualquier propósito, estudiar su funcionamiento, modificarlo según las necesidades propias, y redistribuir copias con o sin modificaciones. No debe confundirse únicamente con \"gratuito\"; lo central es la libertad de control sobre el software, no el precio.  Fuentes: Obtenida de internet.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nodos`
--

CREATE TABLE `nodos` (
  `id` bigint(15) NOT NULL,
  `id_grafo` bigint(15) NOT NULL,
  `nombren` varchar(90) NOT NULL,
  `contenidon` varchar(500) NOT NULL,
  `img` varchar(264) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `nodos`
--

INSERT INTO `nodos` (`id`, `id_grafo`, `nombren`, `contenidon`, `img`) VALUES
(30, 30, 'Células eucariotas', 'Suelen tener un volumen entre 1000 y 10 000 veces mayor que la mayoría de las bacterias y arqueas. Si bien algunas viven de forma independiente como organismos unicelulares, como las amebas y las levaduras, otras viven en agrupaciones multicelulares. Como hemos visto, todos los organismos multicelulares más complejos —incluidas las plantas, los animales y los hongos, como las setas— se forman a partir de células eucariotas.', '8a196db1935d29fb55d0d1426009b9726a1080907de552700b'),
(31, 30, 'Núcleo', 'Es típicamente el orgánulo más prominente en una célula eucariota. Está encerrado dentro de dos membranas concéntricas que forman la envoltura nuclear y contiene moléculas de ADN: polímeros extremadamente largos que codifican la información genética del organismo. En el microscopio óptico, estas gigantescas moléculas de ADN se hacen visibles como cromosomas individuales cuando se compactan antes de que una célula se divida en dos células hijas.', '2f4d49908dd3fc53719e9c5175c7f3e9741635315c1b42b0bf'),
(32, 30, 'Mitocondria', 'Las mitocondrias (singular, mitocondria) están presentes en prácticamente todas las células eucariotas y se encuentran entre los orgánulos más visibles del citoplasma.Observadas con un microscopio electrónico, las mitocondrias individuales se encuentran encerradas en dos membranas separadas, con la membrana interna formando pliegues que se proyectan hacia el interior del orgánulo.', '15c9325b9524f775ccd5e28b3e5900169039ed37aa8a331e1d'),
(33, 30, 'Membrana', 'Los núcleos, las mitocondrias y los cloroplastos no son los únicos orgánulos rodeados de membrana en las células eucariotas. El citoplasma contiene una gran cantidad de otros orgánulos rodeados por membranas simples. La mayoría de estas estructuras participan en la capacidad de la célula para importar materias primas y exportar tanto sustancias útiles como productos de desechoEl retículo endoplasmático (RE) es un laberinto irregular de espacios interconectados rodeados por una membrana.', 'd3fc5fde6ab6e5f19054f8b40c0b8ccd2655684c69f7e7646c'),
(34, 30, 'Adn', 'El núcleo contiene la mayor parte del ADN en una célula eucariota.  Los cromosomas se hacen visibles cuando una célula está a punto de dividirse. A medida que una célula eucariota se prepara para dividirse, sus moléculas de ADN se compactan progresivamente (condensan), formando cromosomas con forma de gusano que se pueden distinguir en el microscopio óptico.', 'b64665a6fbe3e7f2f65dad9d6bef08a6f9251927daf5f32212'),
(35, 31, 'SARS-CoV-2', 'Su estudio virológico ha sido fundamental para entender mecanismos de infección, evolución viral mediante mutaciones y el desarrollo acelerado de vacunas, marcando un hito en la historia de la virología moderna y la salud pública global.', '598a94cd37d8a72c34693427c90e285ebec54ea71292a36405'),
(36, 31, 'Respuesta inmune humoral', 'El sistema inmunológico genera una respuesta humoral produciendo anticuerpos específicos, principalmente contra la proteína Spike del virus. Estos anticuerpos neutralizantes impiden que el virus se una al receptor ACE2 y infecte nuevas células. La respuesta puede surgir tras una infección natural o mediante la vacunación. Su intensidad y duración varían entre personas, y la disminución de los anticuerpos con el tiempo puede hacer necesarias dosis de refuerzo para mantener la protección.', '4f7c3bf04a6fc29c6e77448c24ac83db82d3d2e933bfee763a'),
(37, 31, 'Proteína Spike (S)', 'Es una glicoproteína trimérica ubicada en la superficie del SARS-CoV-2, responsable de darle su apariencia de corona. Su función principal es reconocer y unirse al receptor ACE2 de las células huésped para iniciar la infección. Está formada por las subunidades S1 y S2, que requieren activación por corte proteolítico para permitir la fusión de membranas. Por su papel esencial, es el principal objetivo de los anticuerpos neutralizantes y de la mayoría de las vacunas contra COVID-19.', '0b7c44c1bfbdf42e198d27a4bdca8bc4e2d3199bc9d34a9188'),
(38, 31, 'Genoma de ARN viral', 'El genoma del SARS-CoV-2 consiste en una cadena de ARN monocatenario de aproximadamente 30,000 nucleótidos, una de las más extensas entre los virus de ARN. Contiene la información necesaria para producir proteínas estructurales y enzimas esenciales para su replicación. Su organización le otorga cierta capacidad de corrección de errores durante la copia genética; sin embargo, las mutaciones siguen ocurriendo, favoreciendo la aparición de nuevas variantes con características biológicas diferentes.', 'bcd2ea02ab907454e2b3e15686d6ee66793646a46745ee143a'),
(39, 31, 'Vacuna de ARNm', 'Las vacunas de ARN mensajero (ARNm) introducen instrucciones genéticas que permiten a las células producir temporalmente la proteína Spike del SARS-CoV-2. Al reconocer esta proteína como extraña, el sistema inmunológico genera anticuerpos y memoria inmunológica sin provocar la enfermedad. Su desarrollo durante la pandemia marcó un avance científico importante y demostró el potencial de esta tecnología para combatir futuras enfermedades infecciosas.', 'ffe98999758f8b5fb1248b29ce8837051493170e186b7d4775'),
(40, 31, 'Receptor ACE2', 'La enzima convertidora de angiotensina 2 (ACE2) es una proteína presente en diversas células humanas, especialmente en pulmones, vías respiratorias, corazón e intestino. Su función normal está relacionada con la regulación de la presión arterial. El SARS-CoV-2 utiliza ACE2 como receptor de entrada, ya que la proteína Spike se une a ella para iniciar la infección. Esta interacción contribuye a explicar la susceptibilidad de ciertos órganos y algunas de las complicaciones asociadas a la COVID-19.', 'd09eae86e3c8a81ccec105702618f2a8204796f6caef9e38b0'),
(41, 31, 'Proteasas del huésped (Furina/TMPRSS2)', 'La furina y la proteasa transmembrana de serina 2 (TMPRSS2) son enzimas humanas que activan la proteína Spike del SARS-CoV-2 mediante cortes específicos. Este proceso es esencial para que el virus pueda fusionarse con la membrana celular e ingresar a la célula. La acción de la furina favorece una infección más eficiente, mientras que la abundancia de ambas proteasas en las vías respiratorias contribuye a la alta transmisibilidad y capacidad infecciosa del virus.', '08e698f426b606b03ef9a28e49c4cae4eb1c550428e0d94755'),
(42, 31, 'ARN polimerasa viral (RdRp)', 'La ARN polimerasa dependiente de ARN (RdRp) es una enzima del SARS-CoV-2 responsable de copiar su material genético durante la replicación. Es indispensable para la multiplicación viral dentro de las células infectadas. Debido a su función esencial, constituye un importante objetivo terapéutico y puede ser inhibida por antivirales como el remdesivir. Además, su actividad está relacionada con la aparición de mutaciones que favorecen la evolución del virus.', '05071e296b7df08bd9cee5a4f4964fd8b3ea0b4b2e06107b42'),
(43, 31, 'Ciclo de replicación viral', 'Tras ingresar a la célula huésped, el SARS-CoV-2 libera su ARN en el citoplasma y utiliza la maquinaria celular para replicarse. Primero se producen proteínas no estructurales que forman el complejo de replicación encargado de copiar el genoma viral. Después se sintetizan las proteínas estructurales y se ensamblan nuevas partículas virales, que son liberadas para infectar otras células. Este proceso permite la propagación de la infección dentro del organismo.', '0e6b166549b854eaa2e3b5be0545a882d3120061137507cc38'),
(44, 31, 'Mutación genética', 'Las mutaciones son cambios en la secuencia genética del virus que surgen durante la replicación debido a errores de copia. En el SARS-CoV-2, algunas mutaciones, especialmente en la proteína Spike, pueden modificar la transmisibilidad, la capacidad de evadir la respuesta inmunitaria o la gravedad de la enfermedad. La acumulación de estos cambios constituye un proceso evolutivo natural que ha dado origen a las diferentes variantes virales observadas durante la pandemia.', 'ef1c38d2edf86a03e3267c26085c9fd2cc99dad2fb866987eb'),
(45, 31, 'Variante Delta', 'La variante Delta del SARS-CoV-2, detectada inicialmente en India en 2020, se distinguió por su elevada transmisibilidad en comparación con las cepas originales. Sus mutaciones en la proteína Spike aumentaron la afinidad por el receptor ACE2 y favorecieron mayores cargas virales en los infectados. Como resultado, provocó importantes olas de contagios y hospitalizaciones en todo el mundo, hasta ser reemplazada por variantes con una capacidad de propagación aún mayor.', 'aaed1b1ea2abfc3c688143e5840b0916adefbfe6e5871015e3'),
(46, 31, 'Variante Ómicron', 'La variante Ómicron, identificada a finales de 2021, presentó un elevado número de mutaciones, especialmente en la proteína Spike. Estas le permitieron aumentar su capacidad de transmisión y evadir parcialmente la inmunidad generada por infecciones previas o vacunación. Aunque generalmente se asoció con cuadros menos graves que variantes anteriores, su rápida propagación provocó niveles de contagio sin precedentes en numerosos países.', '6b7170a5458437176ec94b0a4d8d0fa0f3a485347c4638d350'),
(47, 32, 'Software Libre', 'Esta filosofía dio origen a proyectos como GNU y a licencias legales como la GPL, sentando las bases ideológicas que después permitieron el surgimiento de sistemas operativos completos como GNU/Linux.', '12d1d411041457ce973a8960904943a4777f9d516584eaf860'),
(48, 32, 'Richard Stallman y el Proyecto GNU', 'En 1983, Richard Stallman anunció el Proyecto GNU con el objetivo de desarrollar un sistema operativo completamente basado en software libre. Posteriormente creó la Free Software Foundation para apoyar esta iniciativa. Su propuesta surgió como respuesta a las restricciones de los programas propietarios, promoviendo la libertad de usar, modificar y compartir software como principio fundamental del movimiento de software libre.', '24cc80983ab22a8e32284cd093e34a5d414694199fb3efbc6a'),
(49, 32, 'Licencia GPL', 'La Licencia Pública General GNU (GPL), creada por Richard Stallman, es una licencia de software libre basada en el principio de copyleft. Esta cláusula exige que cualquier versión modificada o derivada se distribuya bajo la misma licencia, preservando las libertades de uso, estudio, modificación y distribución. Gracias a este mecanismo, la GPL ha sido clave para proteger legalmente proyectos como GNU y gran parte del ecosistema asociado a Linux.', '351043b5c1cb75860423d55f3eceb89dc05deba590d8399d14'),
(50, 32, 'Código abierto vs Software libre', 'Aunque suelen emplearse como sinónimos, el software libre y el código abierto tienen enfoques diferentes. El software libre, promovido por Richard Stallman, se centra en las libertades y derechos de los usuarios. Por su parte, el movimiento de código abierto, impulsado por la Open Source Initiative en 1998, destaca las ventajas prácticas del desarrollo colaborativo. Aunque ambos comparten criterios similares, difieren en su fundamento filosófico.', '9e86d36e9e90c6f8122002521c9dd7f5de75f7b19ba50eccc1'),
(51, 32, 'Núcleo Linux', 'El núcleo Linux es un kernel monolítico creado por Linus Torvalds en 1991. Su función principal es administrar los recursos del hardware, incluyendo memoria, procesos, dispositivos y la comunicación entre software y procesador. Aunque constituye el componente central del sistema, por sí solo no es un sistema operativo completo; requiere herramientas adicionales, como las desarrolladas por el Proyecto GNU, para proporcionar un entorno funcional al usuario.', 'ba3f3da5f3f8275cbcb6ff70c1261d601f8897364c72c9abdd'),
(52, 32, 'GNU', 'GNU es un conjunto de herramientas, bibliotecas y utilidades desarrolladas por el Proyecto GNU para construir un sistema operativo libre similar a Unix. Incluye componentes fundamentales como GCC, Bash y GNU Emacs. A principios de los años noventa, GNU contaba con casi todos los elementos necesarios para un sistema operativo completo, excepto un kernel funcional. La incorporación del núcleo Linux de Linus Torvalds permitió formar lo que hoy se conoce como GNU/Linux.', '8d60ec2469526ebedebb7c7d75f7035c78cf22b855f361d08c'),
(53, 32, 'GNU/Linux', 'GNU/Linux es el sistema operativo formado por la combinación del núcleo Linux con las herramientas y utilidades desarrolladas por el Proyecto GNU. Aunque suele llamarse simplemente “Linux”, ese nombre se refiere estrictamente al kernel. La denominación GNU/Linux destaca la contribución conjunta de ambos proyectos y refleja con mayor precisión el origen histórico y técnico del sistema, una distinción que sigue siendo debatida dentro de la comunidad del software libre.', '3312eb411f368ee6cbe2b63a46c3cb1eb211b49752b2e400a9'),
(54, 32, 'Distribución Linux', 'Una distribución o “distro” es un sistema operativo completo que integra el núcleo Linux, las herramientas de GNU, un gestor de paquetes y, generalmente, un entorno de escritorio. Aunque todas comparten la misma base, difieren en filosofía, métodos de administración, frecuencia de actualización y público objetivo. Comprender este concepto ayuda a distinguir entre Linux como kernel y la distribución completa que los usuarios instalan y utilizan.', '0f41cc23110e337a95bf861fbc93d2ec8ab1317aae95a24473'),
(55, 32, 'Gestor de paquetes', 'Un gestor de paquetes es una herramienta que permite instalar, actualizar y eliminar software, gestionando automáticamente las dependencias necesarias para su funcionamiento. Cada distribución suele utilizar su propio sistema, como APT, RPM o Pacman. Estas diferencias influyen en la administración del sistema y constituyen una de las características prácticas que distinguen a unas distribuciones de otras.', '447f422ea04321b1bd2460c604fb3d8db29adbf233fb28ce73'),
(56, 32, 'Espacio de núcleo vs espacio de usuario', 'La arquitectura de espacio de núcleo y espacio de usuario divide el sistema operativo en dos niveles de privilegio. El espacio de núcleo permite al kernel acceder directamente al hardware y gestionar recursos críticos, mientras que el espacio de usuario ejecuta aplicaciones con permisos limitados. Esta separación mejora la seguridad y estabilidad del sistema, evitando que errores o acciones maliciosas afecten componentes esenciales. La interacción entre ambos niveles se realiza mediante llamadas', '854030ab9899c2c84e4ee3f3f2002db3c859215744947caf21'),
(57, 32, 'Multiprocesamiento', 'El multiprocesamiento es la capacidad del sistema operativo para ejecutar y coordinar múltiples procesos utilizando uno o varios núcleos del procesador. En Linux, esta tarea es gestionada por el planificador (scheduler), que asigna tiempo de CPU a cada proceso para optimizar el rendimiento. En sistemas multinúcleo permite la ejecución simultánea de tareas, mientras que en procesadores de un solo núcleo se logra una alternancia rápida entre procesos que genera la percepción de ejecución concurren', 'dfb63712882869e7688e6b7ad882b08daab753ac2bb5649f58'),
(58, 32, 'Procesos paralelos / Concurrencia', 'La concurrencia y el paralelismo son conceptos relacionados pero distintos. El paralelismo implica la ejecución simultánea de varias tareas utilizando múltiples núcleos de procesamiento. La concurrencia, por su parte, consiste en gestionar varias tareas en progreso alternando rápidamente entre ellas, aunque no se ejecuten al mismo tiempo. Linux admite ambos enfoques mediante su planificador de procesos, permitiendo un uso eficiente de los recursos y una mejor experiencia en entornos multitarea.', '544edae397f5fca0f35b34684e1a362f9ea299c23df9c71777');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relaciones`
--

CREATE TABLE `relaciones` (
  `id` bigint(15) NOT NULL,
  `id_grafo` bigint(15) NOT NULL,
  `de_nodo_id` bigint(15) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `contenido` varchar(90) NOT NULL,
  `a_nodo_id` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `relaciones`
--

INSERT INTO `relaciones` (`id`, `id_grafo`, `de_nodo_id`, `nombre`, `contenido`, `a_nodo_id`) VALUES
(1, 30, 30, 'Contiene Núcleo', 'Componente principal', 31),
(2, 30, 30, 'Contiene Mitocondria', 'Organelo que produce energía, Genera ATP para la célula, Central energética celular.', 32),
(3, 30, 30, 'Contiene Membrana', 'Define los límites de la célula.\r\nControla qué entra y qué sale.\r\nProtege el interior celu', 33),
(4, 30, 31, 'Almacena Adn', 'Guarda la información genética.\r\nContiene las instrucciones de vida.\r\nProtege herencia adn', 34),
(5, 31, 35, 'Desencadena', 'El organismo reacciona ante la infección.', 36),
(6, 31, 35, 'Posee', 'Esta proteína forma parte de su envoltura externa.', 37),
(7, 31, 35, 'Contiene', 'El virus está compuesto por este material genético.', 38),
(8, 31, 36, 'Es inducida por', 'Las vacunas entrenan esta respuesta sin enfermar.', 39),
(9, 31, 37, 'Se une a', 'Mecanismo de reconocimiento para entrar a la célula.', 40),
(10, 31, 37, 'Es activada por', 'Corte necesario para permitir la fusión viral.', 41),
(11, 31, 38, 'Codifica', 'Esta enzima se produce a partir del genoma viral.', 42),
(12, 31, 40, 'Permite el inicio de', 'La unión desencadena la entrada y replicación.', 43),
(13, 31, 43, 'Genera', 'Errores durante la copia producen variaciones.', 44),
(14, 31, 44, 'Origina', 'Acumulación de cambios genéticos específicos.', 45),
(15, 31, 44, 'Origina', 'Conjunto distinto de mutaciones acumuladas.', 46),
(18, 31, 42, 'Ejecuta', 'Cataliza la copia del material genético.', 43),
(19, 31, 39, 'Enseña a reconocer', 'El ARNm codifica esta proteína como antígeno.', 37),
(20, 32, 47, 'Originó', 'Su filosofía impulsó la creación de este proyecto.', 48),
(21, 32, 47, 'Se protege mediante', 'Esta licencia legal sostiene sus principios.', 49),
(22, 32, 47, 'Se diferencia de', 'Comparten similitudes pero parten de motivaciones distintas.', 50),
(23, 32, 47, 'Inspiró la creación de', 'Su espíritu motivó un desarrollo independiente.', 51),
(24, 32, 48, 'Fundó', 'Dio origen a este conjunto de herramientas.', 52),
(25, 32, 52, 'Se combina con el núcleo para', 'Aporta las herramientas necesarias del sistema.', 53),
(26, 32, 53, 'Se empaqueta en', 'Distintas organizaciones lo ensamblan de forma propia.', 54),
(27, 32, 54, 'Incluye', 'Herramienta para administrar el software instalado.', 55),
(28, 32, 51, 'Implementa', 'Define los niveles de privilegio del sistema.', 56),
(29, 32, 51, 'Gestiona', 'Coordina la ejecución de múltiples procesos.', 57),
(30, 32, 57, 'Se relaciona con', 'Conceptos clave para entender el rendimiento.', 58),
(31, 32, 51, 'Se combina con GNU para formar', 'Aporta el control directo del hardware.', 53);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `grafos`
--
ALTER TABLE `grafos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nodos`
--
ALTER TABLE `nodos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_grafo` (`id_grafo`);

--
-- Indices de la tabla `relaciones`
--
ALTER TABLE `relaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `de_nodo_id` (`de_nodo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `grafos`
--
ALTER TABLE `grafos`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `nodos`
--
ALTER TABLE `nodos`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `relaciones`
--
ALTER TABLE `relaciones`
  MODIFY `id` bigint(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `nodos`
--
ALTER TABLE `nodos`
  ADD CONSTRAINT `nodos_ibfk_1` FOREIGN KEY (`id_grafo`) REFERENCES `grafos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `relaciones`
--
ALTER TABLE `relaciones`
  ADD CONSTRAINT `relaciones_ibfk_1` FOREIGN KEY (`de_nodo_id`) REFERENCES `nodos` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
