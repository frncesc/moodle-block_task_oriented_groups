<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle. If not, see <http://www.gnu.org/licenses/>.

/**
 * Plugin strings in Spanish are defined here.
 *
 * @package block_tog
 * @category string
 * @copyright 2018 UDT-IA, IIIA-CSIC
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Bloque para hacer grupos orientados a tareas';
$string['tog'] = 'Grupos orientados a tareas';

$string['settings:heading'] = 'Un bloque de Moodle para agrupar usuarios dependiendo de la tarea a realizar. Los grupos formados tienen diversidad en género, personalidad e inteligencia.';
$string['settings:base_api_url_title'] = 'Base API URL';
$string['settings:base_api_url_description'] = 'La URL al servicio externo que generará los grupos para una tarea. El servicio que proporcionamos (https://eduteams.iiia.csic.es/saas/) es gratuito sin ninguna limitación en la cantidad de llamadas. Desafortunadamente, tenemos algunos límites físicos en el servidor que solo pueden procesar algunas miles de solicitudes por segundo. Cuando se llama al servicio, almacena la información del encabezado HTTP como la dirección remota o el puerto, el número de estudiantes por equipo, la inteligencia de la solicitud, el rendimiento esperado para los grupos y la lista de estudiantes. Para cada estudiante se almacena un identificador y su personalidad e inteligencia asociadas. El identificador es anónimo, por lo que el servicio que no puede conocer la persona en Moodle asociada con el identificador. Además, almacenó los grupos formados para los estudiantes. Por otro lado, almacenó los comentarios proporcionados por los maestros que se utilizan para evaluar el desempeño de los grupos formados.';

$string['main:composite'] = 'Crea un nuevo grupo por tarea';
$string['main:fill_personality_test'] = 'Completa tu test de personalidad';
$string['main:my_personality'] = 'Mi personalidad';
$string['main:my_intelligences'] = 'Mis inteligencias';
$string['main:fill_intelligences_test'] = 'Completa tu test de inteligencias.';
$string['main:auto_fill_in'] = 'Auto completa los tests';
$string['main:feedback_test'] = 'Proporcionar retroalimentación de los grupos creados';

$string['personality_test_title'] = 'Test de personalidad';
$string['personality_test_heading'] = 'Test de personalidad';
$string['personality_test_go_to_personality'] = 'Mostrar mi personalidad';
$string['personality_test_go_to_course'] = 'Volver al curso';
$string['personality_test_go_to_intelligences_test'] = 'Completa test de inteligencias';
$string['personality_test_storing_msg'] = 'Desant reposta';

$string['personality_question_0'] = 'Yo soy';
$string['personality_question_0_answer_0'] = 'Mujer';
$string['personality_question_0_answer_1'] = 'Hombre';
$string['personality_question_0_answer_2'] = 'Prefiero no contestar';

$string['personality_question_1'] = 'Los jueces deben ser';
$string['personality_question_1_help'] = 'Ejemplo: Si un juez juzga a tu hermano, debe seguir las leyes que valen para todos por igual.';
$string['personality_question_1_answer_0'] = 'Compasivos';
$string['personality_question_1_answer_1'] = 'Imparciales';
$string['personality_question_1_answer_2'] = 'Depende del caso';

$string['personality_question_2'] = 'Prefieres las cosas';
$string['personality_question_2_help'] = 'Ejemplo: Me gusta planear mi día a día o prefiero improvisar.';
$string['personality_question_2_answer_0'] = 'Espontáneas';
$string['personality_question_2_answer_1'] = 'Planificadas';
$string['personality_question_2_answer_2'] = 'Indiferente';

$string['personality_question_3'] = 'Prefieres';
$string['personality_question_3_answer_0'] = 'Lo tradicional';
$string['personality_question_3_answer_1'] = 'Lo nuevo';
$string['personality_question_3_answer_2'] = 'Indiferente';

$string['personality_question_4'] = 'Prefieres';
$string['personality_question_4_answer_0'] = 'Estar solo';
$string['personality_question_4_answer_1'] = 'Estar acompañado';
$string['personality_question_4_answer_2'] = 'Indiferente';

$string['personality_question_5'] = 'Eres más';
$string['personality_question_5_help'] = 'Ejemplo: Crees en las cosas que te dicen o prefieres comprobarlo.';
$string['personality_question_5_answer_0'] = 'Tolerante';
$string['personality_question_5_answer_1'] = 'Escéptico';
$string['personality_question_5_answer_2'] = 'Indiferente';

$string['personality_question_6'] = 'Trabajas mejor';
$string['personality_question_6_answer_0'] = 'Sin presión';
$string['personality_question_6_answer_1'] = 'Con presión';
$string['personality_question_6_answer_2'] = 'Indiferente';

$string['personality_question_7'] = 'Eres más';
$string['personality_question_7_help'] = 'Ejemplo: Cuando hago los deberes, me gusta organizarlo paso a paso siempre en el mismo orden o prefiero empezar al azar.';
$string['personality_question_7_answer_0'] = 'Metódico';
$string['personality_question_7_answer_1'] = 'Improvisador';
$string['personality_question_7_answer_2'] = 'Indiferente';

$string['personality_question_8'] = 'Eres más';
$string['personality_question_8_help'] = 'Ejemplo: Me gustan más las matematicas (teórico) o educación fisica (práctico).';
$string['personality_question_8_answer_0'] = 'Teórico';
$string['personality_question_8_answer_1'] = 'Práctico';
$string['personality_question_8_answer_2'] = 'Indiferente';

$string['personality_question_9'] = 'Eres más';
$string['personality_question_9_help'] = 'Ejemplo: Me gusta contarle todo a que me pasa a mis amigos o prefiero guardarmelo para mi.';
$string['personality_question_9_answer_0'] = 'Reservado';
$string['personality_question_9_answer_1'] = 'Sociable';
$string['personality_question_9_answer_2'] = 'Indiferente';

$string['personality_question_10'] = 'Te ves a ti mismo más';
$string['personality_question_10_help'] = 'Ejemplo: Prefieres construir un robot (Curioso) o comprarlo ya hecho (Acomodado).';
$string['personality_question_10_answer_0'] = 'Acomodado';
$string['personality_question_10_answer_1'] = 'Curioso';
$string['personality_question_10_answer_2'] = 'Indiferente';

$string['personality_question_11'] = 'Eres más';
$string['personality_question_11_answer_0'] = 'Contenido';
$string['personality_question_11_answer_1'] = 'Expresivo';
$string['personality_question_11_answer_2'] = 'Indiferente';

$string['personality_question_12'] = 'Eres más';
$string['personality_question_12_help'] = 'Ejemplo: Digo las cosas como son (honesto) o prefiero omitir las palabras que puedan herir.';
$string['personality_question_12_answer_0'] = 'Diplomático';
$string['personality_question_12_answer_1'] = 'Honesto';
$string['personality_question_12_answer_2'] = 'Indiferente';

$string['personality_question_13'] = 'Prefieres';
$string['personality_question_13_help'] = 'Ejemplo: Prefieres hacer mapas (lo concreto) o resolver problemas matemáticos (lo abstracto).';
$string['personality_question_13_answer_0'] = 'Lo concreto';
$string['personality_question_13_answer_1'] = 'Lo abstracto';
$string['personality_question_13_answer_2'] = 'Indiferente';

$string['personality_question_14'] = 'Eres más';
$string['personality_question_14_answer_0'] = 'Silencioso';
$string['personality_question_14_answer_1'] = 'Hablador';
$string['personality_question_14_answer_2'] = 'Indiferente';

$string['personality_question_15'] = 'Aprendes mejor';
$string['personality_question_15_answer_0'] = 'Leyendo';
$string['personality_question_15_answer_1'] = 'Escuchando';
$string['personality_question_15_answer_2'] = 'Indiferente';

$string['personality_question_16'] = 'Eres más';
$string['personality_question_16_help'] = 'Ejemplo: Te gusta pensar por qué vuelan los aviones (conceptual) o hacer una maqueta de un avión (práctico)';
$string['personality_question_16_answer_0'] = 'Práctico';
$string['personality_question_16_answer_1'] = 'Conceptual';
$string['personality_question_16_answer_2'] = 'Indiferente';

$string['personality_question_17'] = 'Prefieres';
$string['personality_question_17_help'] = 'Ejemplo: Si tu amigo llega 20 minutos tarde, quieres saber porqué (empatía) o te enfadas sin importar el motivo (lógica).';
$string['personality_question_17_answer_0'] = 'Empatía';
$string['personality_question_17_answer_1'] = 'Lógica';
$string['personality_question_17_answer_2'] = 'Indiferente';

$string['personality_question_18'] = 'Prefieres';
$string['personality_question_18_help'] = 'Ejemplo: Cuando hay un robo prefiero investigar los hechos o imaginar lo que ha podido pasar.';
$string['personality_question_18_answer_0'] = 'Investigar';
$string['personality_question_18_answer_1'] = 'Hacer hipótesis';
$string['personality_question_18_answer_2'] = 'Indiferente';

$string['personality_question_19'] = 'Eres más';
$string['personality_question_19_help'] = 'Ejemplo: Cuando me preparo para ir a dormir, siempre sigo el mismo orden (lavar dientes, poner pijama etc).';
$string['personality_question_19_answer_0'] = 'Sistemático';
$string['personality_question_19_answer_1'] = 'Informal';
$string['personality_question_19_answer_2'] = 'Indiferente';

$string['personality_question_20'] = 'Prefieres';
$string['personality_question_20_help'] = 'Ejemplo: Me gusta comer cosas diferentes (variedad) o prefiero comer siempre pizza (rutina).';
$string['personality_question_20_answer_0'] = 'Rutina';
$string['personality_question_20_answer_1'] = 'Variedad';
$string['personality_question_20_answer_2'] = 'Indiferente';

$string['intelligences_test_title'] = 'Prueba de inteligencias';
$string['intelligences_test_heading'] = 'Prueba de inteligencias';
$string['intelligences_test_go_to_intelligences'] = 'Mostrar mis inteligencias';
$string['intelligences_test_go_to_course'] = 'Volver al curso';
$string['intelligences_test_go_to_personality_test'] = 'Completa test de personalidad';
$string['intelligences_test_storing_msg'] = 'Desant reposta';

$string['intelligence_question_0'] = 'No me es difícil decir lo que pienso en el curso de una discusión o debate';
$string['intelligence_question_0_help'] = 'Ejemplo: cuando se discute sobre la independencia de Catalunya, me gusta expresar mi opinión.';
$string['intelligence_question_answer_0'] = 'Totalmente en desacuerdo';
$string['intelligence_question_answer_1'] = 'En desacuerdo';
$string['intelligence_question_answer_2'] = 'Ni de acuerdo ni en desacuerdo';
$string['intelligence_question_answer_3'] = 'De acuerdo';
$string['intelligence_question_answer_4'] = 'Totalmente de acuerdo';

$string['intelligence_question_1'] = 'Prefiero hacer un mapa a explicar a alguien como llegar a un sitio';
$string['intelligence_question_1_help'] = 'Ejemplo: Si me preguntan por un camino, prefiero dibujarlo que explicarlo con mis palabras.';

$string['intelligence_question_2'] = 'Si estoy enfadado(a) o contento(a) generalmente sé exactamente porqué';

$string['intelligence_question_3'] = 'Sé tocar (o antes sabía tocar) un instrumento musical';
$string['intelligence_question_3_help'] = 'Ejemplo: sé tocar la guitarra.';

$string['intelligence_question_4'] = 'Asocio música con mis estados de ánimo';
$string['intelligence_question_4_help'] = 'Ejemplo: cuando escucho reguetón me siento muy alegre y escucho hip-hop cuando estoy enfadado.';

$string['intelligence_question_5'] = 'Puedo sumar o multiplicar mentalmente con mucha rapidez';

$string['intelligence_question_6'] = 'Puedo ayudar a un(a) amigo(a) a manejar sus sentimientos porque yo lo pude hacer antes con sentimientos parecidos';
$string['intelligence_question_6_help'] = 'Ejemplo: Puedo recomendar a un amigo qué hacer cuando se encuentra triste porque hay veces que yo mismo me he sentido triste y he sabido cómo animarme. Cada vez que me siento triste, voy a jugar con mis mejores amigos :)';

$string['intelligence_question_7'] = 'Me gusta trabajar con calculadoras y computadores';
$string['intelligence_question_7_help'] = 'Ejemplo: Me gustaría aprender programar.';

$string['intelligence_question_8'] = 'Aprendo rápido a bailar un ritmo nuevo';
$string['intelligence_question_8_help'] = 'Ejemplo: Cuando escucho una canción nueva que no conozco, soy capaz de seguir el ritmo y bailar.';

$string['intelligence_question_9'] = 'Disfruto de una buena charla, discurso o sermón';

$string['intelligence_question_10'] = 'Siempre distingo el norte del sur, esté donde esté';
$string['intelligence_question_10_help'] = 'Ejemplo: Ahora mismo sé donde está el norte.';

$string['intelligence_question_11'] = 'Me gusta reunir grupos de personas en una fiesta o en un evento especial';
$string['intelligence_question_11_help'] = 'Ejemplo: Me gusta organizar mi fiesta de cumpleaños.';

$string['intelligence_question_12'] = 'Soy sensible a las vistas, los sonidos y la sensación de las cosas que me rodean';

$string['intelligence_question_13'] = 'La vida me parece vacía sin música';
$string['intelligence_question_13_help'] = 'Ejemplo: Escucho música en el tren.';

$string['intelligence_question_14'] = 'Siempre entiendo los gráficos que vienen en las instrucciones de equipos o instrumentos';
$string['intelligence_question_14_help'] = 'Ejemplo: Soy capaz de montar un mueble de Ikea.';

$string['intelligence_question_15'] = 'Me gusta resolver rompecabezas y entretenerme con juegos electrónicos';
$string['intelligence_question_15_help'] = 'Ejemplo: Me gusta jugar al Monopoly con amigos y familia.';

$string['intelligence_question_16'] = 'Me fue fácil aprender a ir en bicicleta (o a patinar)';

$string['intelligence_question_17'] = 'Me pongo nervioso(a) cuando oigo una discusión o una afirmación que parece ilógica';
$string['intelligence_question_17_help'] = 'Ejemplo: Me pongo nervioso cuando mis padres no me deja levantar de la mesa sin haber comido todo aunque no tenga hambre.';

$string['intelligence_question_18'] = 'Soy capaz de convencer a otros para que sigan mis planes';
$string['intelligence_question_18_help'] = 'Ejemplo: cuando estoy con amigos, soy capaz de convencerlos para hacer juntos lo que a mí más me gusta.';

$string['intelligence_question_19'] = 'Tengo buen sentido del equilibrio y coordinación';
$string['intelligence_question_19_help'] = 'Ejemplo: Se me dan bien deportes como el skate, la natación, el esquí.';

$string['intelligence_question_20'] = 'Con frecuencia veo configuraciones y relaciones entre números con más rapidez y facilidad que otros';
$string['intelligence_question_20_help'] = 'Ejemplo: Enseguida veo el siguiente número de una serie como 3, 6, 9, ...';

$string['intelligence_question_21'] = 'Me gusta construir modelos ( o hacer esculturas)';
$string['intelligence_question_21_help'] = 'Ejemplo: Me encanta construir figuras de Lego.';

$string['intelligence_question_22'] = 'Tengo agudeza para encontrar el significado de las palabras';
$string['intelligence_question_22_help'] = 'Ejemplo: Cuando veo una palabra nueva, soy capaz de adivinar su significado.';

$string['intelligence_question_23'] = 'Puedo distinguir un objeto desde diferentes puntos de vista';
$string['intelligence_question_23_help'] = 'Ejemplo: Aunque esté trabajando con el monitor delante, soy capaz de imaginarme la parte trasera.';

$string['intelligence_question_24'] = 'Me relaciono bien con los animales y disfruto de la responsabilidad de cuidarlos';

$string['intelligence_question_25'] = 'Con frecuencia hago la conexión entre una pieza de música y algún evento de mi vida';
$string['intelligence_question_25_help'] = 'Ejemplo: Cuando oigo "Despacito" de Luís Fonsi recuerdo la fiesta de cumpleaños de mi mejor amiga';

$string['intelligence_question_26'] = 'Me gusta trabajar con números y figuras';
$string['intelligence_question_26_help'] = 'Ejemplo: Me gusta hacer operaciones matemáticas.';

$string['intelligence_question_27'] = 'Me gusta sentarme silenciosamente y reflexionar sobre mis sentimientos íntimos';
$string['intelligence_question_27_help'] = 'Ejemplo: Me gusta reflexionar sobre las actividades que me gustan como patinar.';

$string['intelligence_question_28'] = 'Con sólo mirar la forma de construcciones y estructuras me siento a gusto';
$string['intelligence_question_28_help'] = 'Ejemplo: Me gusta observar la Torre Eiffel.';

$string['intelligence_question_29'] = 'Me gusta tararear, silbar y cantar en la ducha o cuando estoy solo(a)';

$string['intelligence_question_30'] = 'La información de estudios reales y estudios sociales me da un tiempo de disfrute de la calidad';

$string['intelligence_question_31'] = 'Soy bueno(a) para el atletismo';

$string['intelligence_question_32'] = 'Me gusta escribir cartas detalladas a mis amigos';
$string['intelligence_question_32_help'] = 'Ejemplo: Cuando envio un Whatsapp, me gusta contar muchos detalles.';

$string['intelligence_question_33'] = 'Generalmente me doy cuenta de la expresión que tengo en la cara';
$string['intelligence_question_33_help'] = 'Ejemplo: Cuando siento vergüenza sé que me pongo muy rojo, cuando estoy alegre mis ojos están abiertos como platos y cuando me siento triste sé que mis párpados bajan.';

$string['intelligence_question_34'] = 'Me doy cuenta de las expresiones en la cara de otras personas';
$string['intelligence_question_34_help'] = 'Ejemplo: Me doy cuenta de si alguien está enfadado o triste por la expresión de su cara.';

$string['intelligence_question_35'] = 'Cuidar el medioambiente es una prioridad';

$string['intelligence_question_36'] = 'Me mantengo "en contacto" con mis estados de ánimo. No me cuesta identificarlos';
$string['intelligence_question_36_help'] = 'Ejemplo: Me doy cuenta de si estoy enfadado, alegre o triste.';

$string['intelligence_question_37'] = 'Me doy cuenta de los estados de ánimo de otros';
$string['intelligence_question_37_help'] = 'Ejemplo: Me doy cuenta cuando mi madre está enfadada.';

$string['intelligence_question_38'] = 'Me doy cuenta bastante bien de lo que otros piensan de mí';

$string['intelligence_question_39'] = 'Me siento en casa al aire libre y en un entorno natural';

$string['store_personality_answer_error_title'] = 'Error';
$string['store_personality_answer_error_text'] = 'No se pudo almacenar la respuesta de tu personalidad.';
$string['store_personality_answer_error_continue'] = 'De acuerdo';

$string['store_intelligences_answer_error_title'] = 'Error';
$string['store_intelligences_answer_error_text'] = 'No se pudo almacenar la respuesta de tu inteligencia.';
$string['store_intelligences_answer_error_continue'] = 'De acuerdo';

$string['privacy:metadata:block_tog_perso_answers'] = 'Información sobre las respuestas del usuario a las preguntas del test de personalidad.';
$string['privacy:metadata:block_tog_perso_answers:userid'] = 'El ID del usuario que responde la pregunta.';
$string['privacy:metadata:block_tog_perso_answers:question'] = 'El identificador de la pregunta.';
$string['privacy:metadata:block_tog_perso_answers:answer'] = 'El identificador de la respuesta en la pregunta.';
$string['privacy:export:block_tog_perso_answers'] = 'Test de personalidad';

$string['privacy:metadata:block_tog_intel_answers'] = 'Información sobre las respuestas del usuario a las preguntas del test de inteligencias.';
$string['privacy:metadata:block_tog_intel_answers:userid'] = 'El ID del usuario que responde la pregunta.';
$string['privacy:metadata:block_tog_intel_answers:question'] = 'El identificador de la pregunta.';
$string['privacy:metadata:block_tog_intel_answers:answer'] = 'El identificador de la respuesta en la pregunta.';
$string['privacy:export:block_tog_intel_answers'] = 'Prueba de inteligencias';

$string['privacy:metadata:block_tog_personality'] = 'Información sobre la personalidad de un usuario.';
$string['privacy:metadata:block_tog_personality:userid'] = 'El ID del usuario al que se refiere la personalidad.';
$string['privacy:metadata:block_tog_personality:type'] = 'El tipo de personalidad.';
$string['privacy:metadata:block_tog_personality:gender'] = 'El género del usuario.';
$string['privacy:metadata:block_tog_personality:judgment'] = 'El factor de personalidad del juicio del usuario.';
$string['privacy:metadata:block_tog_personality:attitude'] = 'El factor de actitud de la personalidad del usuario.';
$string['privacy:metadata:block_tog_personality:perception'] = 'La percepción del factor de personalidad del usuario.';
$string['privacy:metadata:block_tog_personality:gender'] = 'El factor de personalidad extrovertido del usuario.';
$string['privacy:export:block_tog_personality'] = 'Personalidad';

$string['privacy:metadata:block_tog_intelligences'] = 'Información sobre las inteligencias de un usuario.';
$string['privacy:metadata:block_tog_intelligences:userid'] = 'El ID del usuario al que se refieren las inteligencias.';
$string['privacy:metadata:block_tog_intelligences:verbal'] = 'El factor de inteligencia verbal del usuario.';
$string['privacy:metadata:block_tog_intelligences:logic_mathematics'] = 'El factor de inteligencia lógico / matemático del usuario.';
$string['privacy:metadata:block_tog_intelligences:visual_spatial'] = 'El factor de inteligencia visual / espacial del usuario.';
$string['privacy:metadata:block_tog_intelligences:kinestesica_corporal'] = 'El factor de inteligencia cinestésica / corporal del usuario.';
$string['privacy:metadata:block_tog_intelligences:musical_rhythmic'] = 'El factor de inteligencia musical / rítmica del usuario.';
$string['privacy:metadata:block_tog_intelligences:intrapersonal'] = 'El factor de inteligencia intrapersonal del usuario.';
$string['privacy:metadata:block_tog_intelligences:interpersonal'] = 'El factor de inteligencia interpersonal del usuario.';
$string['privacy:metadata:block_tog_intelligences:naturalist_environmental'] = 'El factor naturalista / inteligencia ambiental del usuario.';
$string['privacy:export:block_tog_intelligences'] = 'Inteligencias';

$string['personality_title'] = 'Personalidad';
$string['personality_heading'] = 'Personalidad';
$string['personality_go_to_test'] = 'Modificar test de personalidad';
$string['personality_read_more'] = 'Leer mas';
$string['personality_msg'] = 'Tu personalidad es {$a->type} ( {$a->name} ). {$a->description}';
$string['personality_ENFJ_description'] = 'Líderes carismáticos e inspiradores, capaces de hipnotizar a sus oyentes.';
$string['personality_ENFJ_more'] = 'https://www.16personalities.com/enfj-personality';
$string['personality_ENFJ_name'] = 'El protagonista';
$string['personality_ENFP_description'] = 'Espíritus libres entusiastas, creativos y sociables, que siempre pueden encontrar un motivo para sonreír.';
$string['personality_ENFP_more'] = 'https://www.16personalities.com/enfp-personality';
$string['personality_ENFP_name'] = 'El activista';
$string['personality_ENTJ_description'] = 'Líderes audaces, imaginativos y de voluntad fuerte, siempre encontrando un camino, o haciendo uno.';
$string['personality_ENTJ_more'] = 'https://www.16personalities.com/entj-personality';
$string['personality_ENTJ_name'] = 'El comandante';
$string['personality_ENTP_description'] = 'Pensadores inteligentes y curiosos que no pueden resistir un desafío intelectual.';
$string['personality_ENTP_more'] = 'https://www.16personalities.com/entp-personality';
$string['personality_ENTP_name'] = 'El debator';
$string['personality_ESFJ_description'] = 'Gente extraordinariamente cariñosa, social y popular, siempre dispuesta a ayudar.';
$string['personality_ESFJ_more'] = 'https://www.16personalities.com/esfj-personality';
$string['personality_ESFJ_name'] = 'El cónsul';
$string['personality_ESFP_description'] = 'Gente espontánea, enérgica y entusiasta: la vida nunca es aburrida a su alrededor.';
$string['personality_ESFP_more'] = 'https://www.16personalities.com/esfp-personality';
$string['personality_ESFP_name'] = 'El animador';
$string['personality_ESTJ_description'] = 'Excelentes administradores, insuperables en la gestión de cosas, o personas.';
$string['personality_ESTJ_more'] = 'https://www.16personalities.com/estj-personality';
$string['personality_ESTJ_name'] = 'El ejecutivo';
$string['personality_ESTP_description'] = 'Personas inteligentes, enérgicas y muy perceptivas, que disfrutan realmente de vivir al límite.';
$string['personality_ESTP_more'] = 'https://www.16personalities.com/estp-personality';
$string['personality_ESTP_name'] = 'El emprendedor';
$string['personality_INFJ_description'] = 'Idealistas tranquilos y místicos, pero muy inspiradores e incansables.';
$string['personality_INFJ_more'] = 'https://www.16personalities.com/infj-personality';
$string['personality_INFJ_name'] = 'El abogado';
$string['personality_INFP_description'] = 'Gente poética, amable y altruista, siempre dispuesta a ayudar por una buena causa.';
$string['personality_INFP_more'] = 'https://www.16personalities.com/infp-personality';
$string['personality_INFP_name'] = 'El mediador';
$string['personality_INTJ_description'] = 'Pensadores imaginativos y estratégicos, con un plan para todo.';
$string['personality_INTJ_more'] = 'https://www.16personalities.com/intj-personality';
$string['personality_INTJ_name'] = 'El arquitecto';
$string['personality_INTP_description'] = 'Inventores innovadores con una insaciable sed de conocimiento. Pensadores imaginativos y estratégicos, con un plan para todo.';
$string['personality_INTP_more'] = 'https://www.16personalities.com/intp-personality';
$string['personality_INTP_name'] = 'El logico';
$string['personality_ISFJ_description'] = 'Protectores muy dedicados y cálidos, siempre listos para defender a sus seres queridos.';
$string['personality_ISFJ_more'] = 'https://www.16personalities.com/isfj-personality';
$string['personality_ISFJ_name'] = 'El defensor';
$string['personality_ISFP_description'] = 'Artistas flexibles y encantadores, siempre listos para explorar y experimentar algo nuevo.';
$string['personality_ISFP_more'] = 'https://www.16personalities.com/isfp-personality';
$string['personality_ISFP_name'] = 'El aventurero';
$string['personality_ISTJ_description'] = 'Personas prácticas y objetivas, cuya fiabilidad no se puede dudar.';
$string['personality_ISTJ_more'] = 'https://www.16personalities.com/istj-personality';
$string['personality_ISTJ_name'] = 'El logistico';
$string['personality_ISTP_description'] = 'Experimentadores audaces y prácticos, maestros de todo tipo de herramientas.';
$string['personality_ISTP_more'] = 'https://www.16personalities.com/istp-personality';
$string['personality_ISTP_name'] = 'El virtuoso';
$string['personality_error_not_answered_all_questions'] = 'Tienes que responder todas las preguntas del cuestionario para poder saber tu personalidad';
$string['personality_go_to_course'] = 'Volver al curso';
$string['personality_go_to_intelligences_test'] = 'Completa test de inteligencias';

$string['intelligences_title'] = 'Inteligencias';
$string['intelligences_heading'] = 'Inteligencias';
$string['intelligences_msg'] = 'Tus inteligencias son';
$string['intelligences_value_0'] = 'Conciencia fundamental';
$string['intelligences_value_1'] = 'Principiante';
$string['intelligences_value_2'] = 'Intermedio';
$string['intelligences_value_3'] = 'Avanzado';
$string['intelligences_value_4'] = 'Experto';
$string['intelligences_interpersonal_factor'] = 'Inteligencia interpersonal';
$string['intelligences_intrapersonal_factor'] = 'Inteligencia intrapersonal';
$string['intelligences_kinestesica_corporal_factor'] = 'Inteligencia corporal-cinestésica';
$string['intelligences_logic_mathematics_factor'] = 'Inteligencia logico-matematica';
$string['intelligences_musical_rhythmic_factor'] = 'Inteligencia musical';
$string['intelligences_naturalist_environmental_factor'] = 'Inteligencia naturalista-ambiental.';
$string['intelligences_verbal_factor'] = 'Inteligencia lingüística';
$string['intelligences_visual_spatial_factor'] = 'Inteligencia visual-espacial';
$string['intelligences_go_to_test'] = 'Modificar la prueba de inteligencias.';
$string['intelligences_error_not_answered_all_questions'] = 'Tienes que responder todas las preguntas del cuestionario para poder saber tus inteligencias';
$string['intelligences_go_to_course'] = 'Volver al curso';
$string['intelligences_go_to_personality_test'] = 'Completa test de personalidad';

$string['composite_title'] = 'Grupos compuestos';
$string['composite_heading'] = 'Grupos compuestos por tarea';
$string['composite_alert_no_capability'] = 'No tienes la capacidad de componer grupos. Pedir al administrador los privilegios necesarios para hacerlo.';
$string['composite_grouping_name'] = 'Nombre de agrupación';
$string['composite_grouping_name_placeholder'] = 'Escribe el nombre de la agrupación.';
$string['composite_grouping_name_help'] = 'El nombre asociado al grupo que será compuesto.';
$string['composite_groups_pattern'] = 'Patrón de grupo';
$string['composite_groups_pattern_default'] = 'Grupo {}';
$string['composite_groups_pattern_help'] = 'El patrón utilizado para generar el nombre de los grupos. El símnolo {} será reemplazado por el índice del grupo generado.';
$string['composite_members_per_group'] = 'Miembros por grupo';
$string['composite_members_per_group_help'] = 'El número de alumnos que debe haber en cada grupo generado.';
$string['composite_error_not_enough_users'] = 'No hay suficientes usuarios que hayan completado las pruebas de personalidad e inteligencia.';
$string['composite_column_name'] = 'Nombre de usuario';
$string['composite_column_personality'] = 'Rellene el test de personalidad.';
$string['composite_column_personality_not_filled'] = 'El usuario no ha rellenado el test de personalidad.';
$string['composite_column_personality_filled'] = 'El usuario ha rellenado el test de personalidad.';
$string['composite_column_intelligences'] = 'Rellenar prueba de inteligencias';
$string['composite_column_intelligences_not_filled'] = 'El usuario no ha rellenado el test de inteligencias.';
$string['composite_column_intelligences_filled'] = 'El usuario ha rellenado el test de inteligencias.';
$string['composite_column_send'] = 'Enviar mensaje';
$string['composite_column_send_alt'] = 'Envíe un mensaje al usuario que no haya completado la prueba de personalidad o de inteligencia.';
$string['composite_unfilled_msg'] = 'Hay {$a} usuarios que no han completado la prueba de personalidad o inteligencia. Sin esta información no es posible saber a qué grupo ir, por lo que no se agregarán a ningún grupo. En la siguiente tabla podrás saber quiénes son.';
$string['composite_select_role_for_users'] = 'Seleccionar miembros con rol';
$string['composite_select_role_for_users_help'] = 'Seleccione el rol para los miembros que deben usarse para formar los grupos';
$string['composite_send_selected'] = 'Enviar mensaje a los seleccionados';
$string['composite_send_all'] = 'Enviar mensaje a todos';
$string['composite_members_per_group_how_many_pattern'] = 'Puede formar {{groups}} grupos con {{size}} miembros en cada uno';
$string['composite_members_per_group_how_many_pattern_2'] = 'Puede formar {{groups1}} grupos con {{size1}} miembros en cada uno y {{groups2}} grupos con {{size2}} miembros en cada uno';
$string['composite_requirements'] = 'Requerimientos';
$string['composite_requirements_help'] = 'Requisitos que son necesarios para realizar la tarea en cuestión.';
$string['composite_requirements_add'] = 'Añadir';
$string['composite_requirements_factor'] = 'Factor';
$string['composite_requirements_factor_help'] = 'Las inteligencias requeridas de los grupos miembros para realizar la tarea en cuestión.';
$string['composite_requirements_factor_0'] = 'Lingüístico';
$string['composite_requirements_factor_1'] = 'Matemática-lógica';
$string['composite_requirements_factor_2'] = 'Visual-espacial';
$string['composite_requirements_factor_3'] = 'Corporal-cinestésico';
$string['composite_requirements_factor_4'] = 'Musical';
$string['composite_requirements_factor_5'] = 'Intrapersonal';
$string['composite_requirements_factor_6'] = 'Interpersonal';
$string['composite_requirements_factor_7'] = 'Naturalista-ambiental';
$string['composite_requirements_importance'] = 'Importancia';
$string['composite_requirements_importance_help'] = 'La importancia de esta inteligencia para realizar la tarea en cuestión.';
$string['composite_requirements_importance_0'] = 'No tan importante';
$string['composite_requirements_importance_1'] = 'Un poco importante';
$string['composite_requirements_importance_2'] = 'Importante';
$string['composite_requirements_importance_3'] = 'Bastante importante';
$string['composite_requirements_importance_4'] = 'Muy importante';
$string['composite_requirements_level'] = 'Nivel';
$string['composite_requirements_level_help'] = 'El nivel de inteligencia requerido.';
$string['composite_requirements_level_0'] = 'Conciencia fundamental';
$string['composite_requirements_level_1'] = 'Principiante';
$string['composite_requirements_level_2'] = 'Intermedio';
$string['composite_requirements_level_3'] = 'Avanzado';
$string['composite_requirements_level_4'] = 'Experto';
$string['composite_requirements_none'] = 'Por el momento la tarea no tiene requisitos de inteligencia. Los miembros se agrupan en función del género y la personalidad.';
$string['composite_requirements_pattern'] = 'Para la inteligencia {$a->factor} es {$a->importance} un nivel mínimo de {$a->level} nivel';
$string['composite_performance'] = 'Actuación';
$string['composite_performance_help'] = 'Defina si desea más rendimiento o grupos de bajo rendimiento.';
$string['composite_performance_over'] = 'Sobre rendimiento';
$string['composite_performance_under'] = 'Bajo rendimiento';
$string['composite_submit'] = 'Grupos compuestos';
$string['composite_progress'] = 'Calculador';
$string['composite_groups_error_title'] = 'Error';
$string['composite_groups_error_text'] = 'No se pueden calcular los grupos.';
$string['composite_groups_error_continue'] = 'De acuerdo';

$string['externallib:group_description_reponsable_of'] = 'es responsable de';
$string['externallib:group_description_no_responsibility'] = 'no tiene responsabilidad por el grupo';
$string['externallib:group_description_last_intelligence_and'] = 'y';
$string['externallib:group_description_intelligence_interpersonal'] = 'Inteligencia interpersonal';
$string['externallib:group_description_intelligence_intrapersonal'] = 'Inteligencia intrapersonal';
$string['externallib:group_description_intelligence_kinestesica_corporal'] = 'Inteligencia corporal-cinestésica';
$string['externallib:group_description_intelligence_logic_mathematics'] = 'Inteligencia logico-matematica';
$string['externallib:group_description_intelligence_musical_rhythmic'] = 'Inteligencia musical';
$string['externallib:group_description_intelligence_naturalist_environmental'] = 'Inteligencia naturalista-ambiental.';
$string['externallib:group_description_intelligence_verbal'] = 'Inteligencia lingüística';
$string['externallib:group_description_intelligence_visual_spatial'] = 'Inteligencia visual-espacial';

$string['auto_fill_in_title'] = 'Auto rellenar los questionarios';
$string['auto_fill_in_heading'] = 'Auto rellenar los questionarios de los usuarios';
$string['auto_fill_in_column_name'] = 'Nombre usuario';
$string['auto_fill_in_column_personality'] = 'Rellenar el test de personlidad';
$string['auto_fill_in_submit_personality'] = 'Autorellenar';
$string['auto_fill_in_column_personality_filled'] = 'El usuario ya ha rellenado el questionario de personalidad';
$string['auto_fill_in_column_intelligences'] = 'Rellenar el test de inteligencias';
$string['auto_fill_in_submit_intelligences'] = 'Autorellenar';
$string['auto_fill_in_column_intelligences_filled'] = 'El usuario ya ha rellenado el questionario de inteligencias';

$string['feedback_test_title'] = 'Proporcionar retroalimentación sobre el desempeño de un equipo compuesto';
$string['feedback_test_heading'] = 'Proporcionar retroalimentación sobre el desempeño de un equipo compuesto';
$string['feedback_question_0'] = 'El grupo se ha organizado y ha colaborado, todo el mundo se ha implicado en las tareas a realizar';
$string['feedback_question_1'] = 'Todo el grupo ha hablado con el fin de tomar acuerdos y planificar las tareas';
$string['feedback_question_2'] = 'El grupo ha trabajado de manera autónoma: los problemas han sido solucionados dentro del grupo, y las soluciones se han encontrado entre todos';
$string['feedback_question_3'] = 'El grupo ha hecho una coevaluación de manera crítica y responsable';
$string['feedback_question_answer_0'] = 'Poco';
$string['feedback_question_answer_1'] = 'Ni mucho ni poco';
$string['feedback_question_answer_2'] = 'Mucho';
$string['feedback_test_submit'] = 'Informar de los comentarios';
$string['feedback_test_progress'] = 'Informando';
$string['feedback_test_groups_error_title'] = 'Error';
$string['feedback_test_groups_error_text'] = 'No se pudo informar del desenpeño del grupo.';
$string['feedback_test_groups_error_continue'] = 'De acuerdo';
$string['feedback_test_alert_no_capability'] = 'No tienes la capacidad de informar del desenpeño de de un grupo. Pedir al administrador los privilegios necesarios para hacerlo.';
$string['feedback_test_alert_empty'] = 'No hay grupos para informar del desenpeño de sus integrantes.';
$string['feedback_test_grouping_selector'] = 'Selecciona un conjunto de grupos';
$string['feedback_test_grouping_selector_help'] = 'Debes selecionar el conjunto donde esta definido el grupo que quieres informar del desenpeño de sus integrantes.';
$string['feedback_test_group_selector'] = 'Selecciona un grupo';
$string['feedback_test_group_selector_help'] = 'Debes selecionar el grupo que quieres informar del desenpeño de sus integrantes.';
$string['feedback_test_group'] = 'Grupo';
$string['feedback_test_group_help'] = 'Debes selecionar el grupo que quieres informar del desenpeño de sus integrantes.';
$string['feedback_test_alert_submit_success'] = 'Sus comentarios han sido almacenados.';
