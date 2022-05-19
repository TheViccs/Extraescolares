<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Extraescolares</title>
    <!-- IMPORTS -->
    <?php include "../../../views/layout/imports.php" ?>
    <style>
        .main {
            width: 100% !important;
            height: auto;
            display: inline-grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto;
            grid-gap: 10px;
            align-items: center;
            justify-items: center;
        }

        .boton-mostrar-grupos {
            border-radius: 10px;
        }

        .boton-mostrar-grupos:hover {
            background-color: orange;
        }

        .content {
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            overflow-y: auto;
        }

        .contenedor-programa {
            width: 90%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
        }

        .contenedor-programa-titulo {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
        }

        .titulo-programa {
            padding-left: 20px;
        }


        .contenedor-programa-titulo:hover {
            cursor: pointer;
        }

        .contenedor-actividades {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
        }

        .contenedor-actividad {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            grid-auto-rows: auto;
            justify-items: center;
            align-items: center;
        }

        .contenedor-actividad-caracteristicas {
            width: 80%;
            padding-top: 8px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .contenedor-actividad-boton {
            grid-column-start: 1;
            grid-column-end: 3;
            grid-row-start: 3;
            grid-row-end: 4;
            width: 80%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding-bottom: 8px;
        }

        .contenedor-actividades-titulo {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
            background-color: lightgray;
        }

        .contenedor-actividades-titulo:hover {
            cursor: pointer;
        }

        .contenedor-grupos {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
        }

        .contenedor-grupo {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
        }

        .contenedor-grupo-titulo {
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
            background-color: white;
        }

        .contenedor-grupo-titulo:hover{
            cursor: pointer;
        }

        .descripcion-grupo {
            width: 100%;
            height: 300px;
        }
    </style>
</head>

<body>
    <div class="h-100 w-100 d-flex flex-column bg-white">
        <!-- HEADER -->
        <?php include "../../../views/layout/header.php" ?>

        <!-- CONTENT -->
        <div class="d-flex flex-column align-items-center bg-white" style="width: 100% !important; min-height: calc(100% - 137px) !important; overflow-y:auto;">
            <div class="content">
                <h1>Actividades</h1>
                <div class="main">
                    

                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <?php include "../../../views/layout/footer.php" ?>
    </div>
    <script>
        const mostrarContenido = () => {
            if (this.event.currentTarget.nextElementSibling.hasAttribute("hidden")) {
                this.event.currentTarget.nextElementSibling.removeAttribute("hidden");
            } else {
                this.event.currentTarget.nextElementSibling.setAttribute("hidden", true);
            }

        }

        const crearProgramas = () => {
            let programas = [{
                id_programa: "1",
                nombre: "Deportivo"
            }, {
                id_programa: "2",
                nombre: "Cultural"
            }, {
                id_programa: "3",
                nombre: "Academico"
            }]
            let main = document.getElementsByClassName("main")[0];
            programas.forEach(programa => {
                let divContenedor = document.createElement("div");
                divContenedor.classList.add("contenedor-programa");
                let divTitulo = document.createElement("div")
                divTitulo.classList.add("contenedor-programa-titulo");
                divTitulo.setAttribute("onclick", "mostrarContenido()");
                divTitulo.classList.add("titulo-programa");
                let h3 = document.createElement("h3");
                h3.textContent = programa.nombre;
                divTitulo.appendChild(h3);
                let divContenido = document.createElement("div");
                divContenido.classList.add("contenedor-actividades");
                divContenido.id = "programa" + programa.id_programa;
                divContenido.setAttribute("hidden", true);
                divContenedor.appendChild(divTitulo);
                divContenedor.appendChild(divContenido);
                main.appendChild(divContenedor);
            });
        }
        crearProgramas();

        const crearActividades = () => {
            let actividades = [{
                id_actividad: "1",
                nombre: "Futbol",
                descripcion: "eferf efr ferferf erferf erferfe erfer ferferf erferferf erferfr rferf rfrfre rferferf erferf erfer erfee rferf erfe rferferf",
                competencia: "eferf efr ferferf erferf erferfe erfer ferferf erferferf erferfr rferf rfrfre rferferf erferf erfer erfee rferf erfe rferferf",
                creditos_otorga: 1,
                beneficios: "eferf efr ferferf erferf erferfe erfer ferferf erferferf erferfr rferf rfrfre rferferf erferf erfer erfee rferf erfe rferferf",
                id_programa: "1"
            }, {
                id_actividad: "2",
                nombre: "Basquetbol",
                descripcion: "",
                competencia: "",
                creditos_otorga: 1,
                beneficios: "",
                id_programa: "1"
            }, {
                id_actividad: "3",
                nombre: "Danza",
                descripcion: "",
                competencia: "",
                creditos_otorga: 1,
                beneficios: "",
                id_programa: "2"
            }, {
                id_actividad: "4",
                nombre: "Tutoria",
                descripcion: "",
                competencia: "",
                creditos_otorga: 1,
                beneficios: "",
                id_programa: "3"
            }]
            actividades.forEach(actividad => {
                let programa = document.querySelector("#programa" + actividad.id_programa);
                let divContenedor = document.createElement("div");
                divContenedor.classList.add("contenedor-actividades");
                let divTitulo = document.createElement("div");
                divTitulo.classList.add("contenedor-actividades-titulo");
                divTitulo.setAttribute("onclick", "mostrarContenido()");
                let h3 = document.createElement("h3");
                h3.textContent = actividad.nombre;
                divTitulo.appendChild(h3);
                let contenedorActividad = document.createElement("div");
                contenedorActividad.classList.add("contenedor-actividad");
                contenedorActividad.setAttribute("hidden", true);

                let divContenedorDescripcion = document.createElement("div");
                divContenedorDescripcion.classList.add("contenedor-actividad-caracteristicas");
                let tituloDescripcion = document.createElement("h5");
                tituloDescripcion.textContent = "Descripción"
                let descripcion = document.createElement("p");
                descripcion.textContent = actividad.descripcion;
                divContenedorDescripcion.appendChild(tituloDescripcion);
                divContenedorDescripcion.appendChild(descripcion);

                let divContenedorCompetencia = document.createElement("div");
                divContenedorCompetencia.classList.add("contenedor-actividad-caracteristicas");
                let tituloCompetencia = document.createElement("h5");
                tituloCompetencia.textContent = "Competencia"
                let competencia = document.createElement("p");
                competencia.textContent = actividad.competencia;
                divContenedorCompetencia.appendChild(tituloCompetencia);
                divContenedorCompetencia.appendChild(competencia);

                let divContenedorBeneficios = document.createElement("div");
                divContenedorBeneficios.classList.add("contenedor-actividad-caracteristicas");
                let tituloBeneficios = document.createElement("h5");
                tituloBeneficios.textContent = "Beneficios"
                let beneficios = document.createElement("p");
                beneficios.textContent = actividad.beneficios;
                divContenedorBeneficios.appendChild(tituloBeneficios);
                divContenedorBeneficios.appendChild(beneficios);

                let divContenedorCreditos = document.createElement("div");
                divContenedorCreditos.classList.add("contenedor-actividad-caracteristicas");
                let tituloCreditos = document.createElement("h5");
                tituloCreditos.textContent = "Creditos que otorga"
                let creditos = document.createElement("p");
                creditos.textContent = actividad.creditos_otorga;
                divContenedorCreditos.appendChild(tituloCreditos);
                divContenedorCreditos.appendChild(creditos);

                let divBotonGrupos = document.createElement("div");
                divBotonGrupos.classList.add("contenedor-actividad-boton");
                let boton = document.createElement("button");
                boton.textContent = "Mostrar grupos";
                boton.classList.add("boton-mostrar-grupos");
                boton.onclick = function() {
                    let contenedorGrupos = document.getElementById("actividad" + actividad.id_actividad);
                    if (contenedorGrupos.style.display === "none") {
                        contenedorGrupos.style.display = "block";
                        boton.textContent = "Ocultar grupos"
                    } else {
                        contenedorGrupos.style.display = "none";
                        boton.textContent = "Mostrar grupos";
                    }
                }
                divBotonGrupos.appendChild(boton);

                contenedorActividad.appendChild(divContenedorDescripcion);
                contenedorActividad.appendChild(divContenedorCompetencia);
                contenedorActividad.appendChild(divContenedorBeneficios);
                contenedorActividad.appendChild(divContenedorCreditos);
                contenedorActividad.appendChild(divBotonGrupos);

                let divContenido = document.createElement("div")
                divContenido.classList.add("contenedor-grupos");
                divContenido.id = "actividad" + actividad.id_actividad;
                divContenido.style.display = "none";
                programa.appendChild(divTitulo);
                programa.appendChild(contenedorActividad);
                programa.appendChild(divContenido);
            });
        }
        crearActividades();

        const crearGrupos = () => {
            let grupos = [{
                id_grupo: "1",
                nombre: "A",
                id_actividad: "1"
            }, {
                id_grupo: "2",
                nombre: "B",
                id_actividad: "1"
            }, {
                id_grupo: "3",
                nombre: "A",
                id_actividad: "2"
            }, {
                id_grupo: "4",
                nombre: "A",
                id_actividad: "3"
            }]
            grupos.forEach(grupo => {
                let actividad = document.querySelector("#actividad" + grupo.id_actividad);
                let divContenedor = document.createElement("div");
                divContenedor.classList.add("contenedor-grupo");
                let divTitulo = document.createElement("div");
                divTitulo.classList.add("contenedor-grupo-titulo");
                divTitulo.setAttribute("onclick", "mostrarContenido()");
                let h3 = document.createElement("h3");
                h3.textContent = "Grupo " + grupo.nombre;
                divTitulo.appendChild(h3);
                let divContenido = document.createElement("div")
                divContenido.classList.add("descripcion-grupo");
                divContenido.id = "grupo" + grupo.id_grupo;
                divContenido.setAttribute("hidden", true);
                actividad.appendChild(divTitulo);
                actividad.appendChild(divContenido);
            });
        }
        crearGrupos();
    </script>
</body>

</html>