<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">API de Operaciones Matemáticas</h1>

        <!-- Formulario para elegir operación -->
        <div class="mb-3">
            <label for="operacion" class="form-label">Selecciona una operación</label>
            <select id="operacion" class="form-select">
                <option value="suma">Suma</option>
                <option value="resta">Resta</option>
                <option value="multiplicacion">Multiplicación</option>
                <option value="division">División</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="valor1" class="form-label">Valor 1</label>
            <input type="number" id="valor1" class="form-control" value="20">
        </div>

        <div class="mb-3">
            <label for="valor2" class="form-label">Valor 2</label>
            <input type="number" id="valor2" class="form-control" value="5">
        </div>

        <div class="text-center">
            <button onclick="realizarOperacion()" class="btn btn-primary mt-3">Realizar Operación</button>
        </div>

        <p id="resultado" class="text-center mt-4"></p>
    </div>

    <script>
    function realizarOperacion() {
        // Obtener valores del formulario
        const operacion = document.getElementById("operacion").value;
        const valor1 = document.getElementById("valor1").value;
        const valor2 = document.getElementById("valor2").value;
        const resultadoElemento = document.getElementById("resultado");

        // Validar que los valores no estén vacíos
        if (valor1 === "" || valor2 === "") {
            resultadoElemento.innerText = "⚠️ Ingresa ambos valores.";
            resultadoElemento.style.color = "red";
            return;
        }

        // Crear objeto con los datos
        const datos = {
            action: operacion,
            valor1: parseFloat(valor1),
            valor2: parseFloat(valor2)
        };

        console.log("Datos enviados a la API:", datos); // Debug

        // Enviar solicitud a la API
        fetch("http://localhost/api_operaciones/api/operaciones_api.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(datos)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.json();
        })
        .then(data => {
            console.log("Respuesta de la API:", data); // Debug

            if (data.resultado !== undefined) {
                resultadoElemento.innerText = "✅ Resultado: " + data.resultado;
                resultadoElemento.style.color = "green";
            } else {
                resultadoElemento.innerText = "⚠️ Error: " + (data.error || "Respuesta inesperada");
                resultadoElemento.style.color = "red";
            }
        })
        .catch(error => {
            console.error("Error en la petición:", error);
            resultadoElemento.innerText = "❌ Error en la conexión con la API.";
            resultadoElemento.style.color = "red";
        });
    }
</script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
