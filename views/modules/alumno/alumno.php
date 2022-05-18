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
            min-height: calc(100% - 137px) !important;
            overflow-y: auto;
            display: inline-grid;
            grid-template-columns: 1fr;
            grid-template-rows: auto;
            grid-gap: 10px;
            justify-content: center;
            align-items: center;
            justify-items: center;
        }

        .content {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
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

        .contenedor-programa-titulo{
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
        }

        .titulo-programa{
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
            border: 1px solid black;
            border-radius: 10px;
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

        .contenedor-grupo-titulo{
            width: 100%;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 1px solid black;
            border-radius: 10px;
            background-color: white;
        }
        
        .descripcion-grupo{
            width: 100%;
            height: 300px;
        }

    </style>
</head>

<body>
    <div class="content h-100 w-100 d-flex flex-column bg-white">
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
                id_programa: "1"
            }, {
                id_actividad: "2",
                nombre: "Basquetbol",
                id_programa: "1"
            }, {
                id_actividad: "3",
                nombre: "Danza",
                id_programa: "2"
            }, {
                id_actividad: "4",
                nombre: "Tutoria",
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
                let divContenido = document.createElement("div")
                divContenido.classList.add("contenedor-grupos");
                divContenido.id = "actividad" + actividad.id_actividad;
                divContenido.setAttribute("hidden", true);
                programa.appendChild(divTitulo);
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
                h3.textContent = "Grupo "+grupo.nombre;
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