<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerador de Rifas</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 900px; /* Aumentado para acomodar o estilo da rifa */
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-size: 2.5em;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #34495e;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52,152,219,0.3);
        }

        .input-currency {
            position: relative;
        }

        .input-currency::before {
            content: "R$";
            position: absolute;
            left: 12px; /* Ajuste a posição para alinhar com o texto */
            top: 50%;
            transform: translateY(-50%);
            color: #555;
            font-weight: bold;
            pointer-events: none; /* Permite clicar no input por trás do pseudo-elemento */
            z-index: 1; /* Garante que o R$ fique por cima */
        }

        .input-currency input[type="number"] {
            padding-left: 40px; /* Adiciona padding para o R$ */
        }

        .btn {
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn i {
            margin-right: 8px;
        }

        .rifas-container {
            margin-top: 30px;
            text-align: center; /* Centraliza os bilhetes */
        }

        .rifa-item {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 20px auto; /* Centraliza cada bilhete */
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            position: relative;
            width: 100%;
            max-width: 800px; /* Ajuste o tamanho conforme necessário para ser mais largo */
            height: 180px; /* Altura fixa para os bilhetes, um pouco maior */
            font-size: 0.9em;
        }

        .rifa-item:hover {
            transform: translateY(-3px) scale(1.01);
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .rifa-stub-left,
        .rifa-stub-right {
            background: #f0f0f0;
            width: 180px; /* Mais largo para o canhoto */
            padding: 15px 10px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            border-right: 1px dashed #999;
            position: relative;
            text-align: center;
            font-family: 'cursive', 'Times New Roman', serif; /* Estilo de fonte para dar um toque mais formal */
            color: #444;
        }

        .rifa-stub-right {
            border-right: none;
            border-left: 1px dashed #999;
        }

        .stub-header {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .stub-emblem {
            font-size: 2.5em; /* Tamanho maior para o ícone */
            color: #888;
            margin-bottom: 10px;
        }

        .rifa-main-content {
            flex-grow: 1;
            padding: 15px 25px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            background-image: radial-gradient(rgba(238,238,238,0.7) 10%, transparent 10%), radial-gradient(rgba(238,238,238,0.7) 10%, transparent 10%);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }

        .ticket-header {
            display: block;
            width: 100%;
            position: relative;
            margin-bottom: 20px;
        }

        .ticket-title {
            font-family: 'Brush Script MT', 'cursive', 'Georgia', serif;
            font-size: 2.5em;
            font-weight: bold;
            color: #333;
            line-height: 1.1;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
        }

        .ticket-subtitle {
            font-size: 1.2em;
            color: #666;
            margin-top: 5px;
            font-style: italic;
            text-align: center;
        }

        .ticket-value-box {
            background: #e74c3c;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1.4em;
            font-weight: bold;
            box-shadow: 2px 2px 5px rgba(0,0,0,0.3);
            text-align: center;
            position: absolute;
            top: 0;
            right: 0;
        }

      

        .ticket-details {
            font-size: 0.9em;
            color: #555;
            margin-bottom: 3px;
        }

        .ticket-prize {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
            text-align: center;
        }

        .ticket-number {
            font-size: 2.2em;
            font-weight: bold;
            color: #3498db;
            text-align: center;
            margin-top: 5px;
        }

        .ticket-fields {
            width: 100%;
        }

        .ticket-fields label {
            font-size: 0.75em;
            margin-bottom: 2px;
            color: #777;
            display: block;
            text-align: left;
            width: 100%;
        }

        .ticket-fields input {
            border: none;
            border-bottom: 1px dashed #999; 
            background: transparent;
            width: 100%;
            padding: 2px 0;
            margin-bottom: 8px;
            font-size: 0.85em;
        }

        .receipt-header {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 10px;
            color: #444;
        }

        .receipt-fields label {
            font-size: 0.7em;
            margin-bottom: 2px;
            color: #777;
            display: block;
            text-align: left;
            width: 100%;
        }

        .receipt-fields input {
            border: none;
            border-bottom: 1px dashed #999;
            background: transparent;
            width: 100%;
            padding: 2px 0;
            margin-bottom: 5px;
            font-size: 0.75em;
        }

        .rifa-stub-left::before, .rifa-stub-right::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 30px; 
            background: linear-gradient(to right, rgba(180,160,130,0.8) 0%, rgba(180,160,130,0) 100%); /* Cor mais escura */
            pointer-events: none;
            z-index: 1; 
        }

        .rifa-stub-left::before {
            left: 0;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
            transform: translateX(-80%) rotateY(25deg);
            transform-origin: right;
        }

        .rifa-stub-right::before {
            right: 0;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            transform: translateX(80%) rotateY(-25deg); /* Ajuste de posição e rotação */
            transform-origin: left;
            background: linear-gradient(to left, rgba(180,160,130,0.8) 0%, rgba(180,160,130,0) 100%);
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .rifas-container, .rifas-container * {
                visibility: visible;
            }
            .rifas-container {
                position: absolute;
                left: 0;
                top: 0;
            }
            .btn {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-ticket-alt"></i> Gerador de Rifas</h1>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="titulo"><i class="fas fa-heading"></i> Título da Rifa:</label>
                <input type="text" id="titulo" name="titulo" required value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="premio"><i class="fas fa-gift"></i> Prêmio(s):</label>
                <input type="text" id="premio" name="premio" required value="<?php echo isset($_POST['premio']) ? htmlspecialchars($_POST['premio']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="quantidade"><i class="fas fa-hashtag"></i> Quantidade de Bilhetes:</label>
                <input type="number" id="quantidade" name="quantidade" min="1" required value="<?php echo isset($_POST['quantidade']) ? htmlspecialchars($_POST['quantidade']) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="valor"><i class="fas fa-dollar-sign"></i> Valor do Bilhete (R$):</label>
                <div class="input-currency">
                    <input type="number" id="valor" name="valor" min="0" step="0.01" required value="<?php echo isset($_POST['valor']) ? htmlspecialchars($_POST['valor']) : ''; ?>">
                </div>
            </div>

            <button type="submit" class="btn">
                <i class="fas fa-magic"></i> Gerar Rifas
            </button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $quantidade = $_POST["quantidade"];
            $titulo = $_POST["titulo"];
            $premio = $_POST["premio"];
            $valor = $_POST["valor"];

            echo "<div class='rifas-container' id='rifasContainer' style='display: block;'>";
            echo "<h2 style='text-align: center; margin-bottom: 20px;'>$titulo</h2>";
            echo "<p style='text-align: center; margin-bottom: 20px;'><strong>Prêmio:</strong> $premio</p>";
            echo "<p style='text-align: center; margin-bottom: 20px;'><strong>Valor:</strong> R$ " . number_format($valor, 2, ',', '.') . "</p>";
            
            for ($i = 1; $i <= $quantidade; $i++) {
                $numero = str_pad($i, 3, "0", STR_PAD_LEFT);
                echo "<div class='rifa-item'>";
                
                // Conteúdo Principal da Rifa
                echo "<div class='rifa-main-content'>";
                echo "<div class='ticket-header'>";
                echo "<div class='ticket-title'>$titulo</div>";
                echo "<div class='ticket-value-box'>Valor do Bilhete<br>R$ " . number_format($valor, 2, ',', '.') . "</div>";
                echo "</div>";
                
                echo "<div class='ticket-prize'>Prêmio: $premio</div>";
                echo "<div class='ticket-number' style='text-align: right;'>Nº $numero</div>";
                echo "</div>";


                echo "</div>"; // Fecha rifa-item
            }

            echo "<button onclick='window.print()' class='btn' style='margin-top: 20px;'>";
            echo "<i class='fas fa-print'></i> Imprimir Rifas";
            echo "</button>";
            echo "</div>";
        }
        ?>
    </div>

    <script>


        // Animação suave ao rolar
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Animação nos inputs
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Animação no botão
        const btn = document.querySelector('.btn');
        btn.addEventListener('mouseover', function() {
            this.style.transform = 'translateY(-3px)';
        });
        
        btn.addEventListener('mouseout', function() {
            this.style.transform = 'translateY(0)';
        });
    </script>
</body>
</html>
