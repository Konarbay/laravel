<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Для поставщиков</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .backqround_menu {
            position: relative;
            height: 70px;
            background-size: 50%;
            background-position: center;
        }

        .backqround_menu:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset('images/backqround_ornament.png') }}');
            background-size: 50%;
            background-position: center;
            opacity: 0.05;
            z-index: -1;
        }

        .header-menu {
            padding: 10px;
        }

        .menu {
            list-style: none;
            display: flex;
            justify-content: space-between;
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .menu li {
            display: inline-block;
        }

        .menu li a {
            text-decoration: none;
            color: #000;
            font-size: 20px;
        }

        .menu li a:hover {
            color: #555;
        }

        .menu li.active a {
            font-weight: bold;
            position: relative;
        }

        .menu li.active a:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #000;
        }
        .footer {
            height: 80px; /* Высота футера */
            background: linear-gradient(to right, #25899C, #1D6B7A); /* Градиент от #25899C к #1D6B7A */
        }

        .social-icons {
            display: flex;
            justify-content: center; /* Center the icons horizontally */
            margin-top: 20px; /* Space above the icons */
        }

        .social-icons a {
            margin: 0 10px; /* Space between the icons */
            color: #e5e7eb; /* Change this to your desired color */
            font-size: 24px; /* Size of the icons */
            text-decoration: none; /* Remove underline from links */
            transition: color 0.3s; /* Smooth transition for hover effect */
        }

        .social-icons a:hover {
            color: white; /* Color on hover */
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function checkFormStatus() {
            const requiredFiles = [
                'file1',
                'file2',
                'file3',
                'file4',
                'file5',
                'file6'
            ];
            const allUploaded = requiredFiles.every(fileId => document.getElementById(fileId).files.length > 0);
            document.getElementById('ajax-submit').disabled = !allUploaded;
        }

        function updateStatus(fileInput, statusId) {
            const status = document.getElementById(statusId);
            if (fileInput.files.length > 0) {
                status.style.display = 'block';
                status.innerHTML = '<span class="text-success">Файл загружен</span>';
            } else {
                status.style.display = 'none';
            }
            checkFormStatus(); // Проверяем статус формы после обновления состояния файла
        }

        $(document).ready(function() {
            // Set up CSRF token for AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#ajax-submit').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Собрать данные вручную
                const formData = new FormData();
                formData.append('email', $('#email').val()); // Добавить email
                const requiredFiles = ['file1', 'file2', 'file3', 'file4', 'file5', 'file6', 'file7'];
                requiredFiles.forEach(fileId => {
                    const fileInput = document.getElementById(fileId);
                    if (fileInput.files.length > 0) {
                        formData.append(fileId, fileInput.files[0]); // Добавить файл
                    }
                });

                $.ajax({
                    url: '{{ route('file.upload') }}', // Убедитесь, что этот маршрут правильный
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        alert('Файлы успешно загружены!');
                    },
                    error: function(xhr, status, error) {
                        alert('Произошла ошибка: ' + error);
                    }
                });
            });

            checkFormStatus(); // Initialize button status
        });
    </script>

</head>
<body>
<div class="container-fluid">
    <div class="row backqround_menu">
        <div class="col-2">
            <img src="{{ asset('images/logo-330x75.png') }}" alt="Logo">
        </div>
    </div>
    <div class="row">
        <div class="header-menu">
            <ul class="menu">
                <li><a href="https://kmgpetrochem.kz/ru/about/company-history">О компании</a></li>
                <li><a href="https://kmgpetrochem.kz/ru/projects">Проекты</a></li>
                <li><a href="https://kmgpetrochem.kz/ru/products">Продукция</a></li>
                <li><a href="https://kmgpetrochem.kz/ru/procurement">Закупки</a></li>
                <li><a href="https://kmgpetrochem.kz/ru/career/hr-policy">Карьера</a></li>
                <li><a href="https://kmgpetrochem.kz/ru/contacts">Контакты</a></li>
                <li class="active"><a href="#">Для поставщиков</a></li>
            </ul>
        </div>
    </div>
    <div class="container mt-5">
        <h2>Для поставщиков</h2>

        <h3>Перечень обязательных необходимых документов для рассмотрения включения в перечень одобренных поставщиков</h3>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="row">
            <div class="col">
                        <input type="hidden" class="form-control" value="konarbay@inbox.ru" id="email" name="email" required>


                    <div class="row">
                        <div class="col-8 mb-3 mt-5">
                            <label for="file1" class="form-label">Заполненная анкета (Excel)</label>
                            <input type="file" class="form-control" id="file1" name="file1" accept=".xls,.xlsx" required onchange="updateStatus(this, 'file1-status')">
                        </div>
                        <div class="col" style="margin-top: 3%;">
                            <div id="file1-status" class="file-upload-status"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8 mb-3">
                            <label for="file2" class="form-label">Учредительные документы (Excel)</label>
                            <input type="file" class="form-control" id="file2" name="file2" accept=".xls,.xlsx" required onchange="updateStatus(this, 'file2-status')">
                        </div>
                        <div class="col" style="margin-top: 3%;">
                            <div id="file2-status" class="file-upload-status"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8 mb-3">
                            <label for="file3" class="form-label">Информация о производимых товарах (PDF)</label>
                            <input type="file" class="form-control" id="file3" name="file3" accept=".pdf" required onchange="updateStatus(this, 'file3-status')">
                        </div>
                        <div class="col" style="margin-top: 3%;">
                            <div id="file3-status" class="file-upload-status"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8 mb-3">
                            <label for="file4" class="form-label">Референтные письма от заказчиков (PDF)</label>
                            <input type="file" class="form-control" id="file4" name="file4" accept=".pdf" required onchange="updateStatus(this, 'file4-status')">
                        </div>
                        <div class="col" style="margin-top: 3%;">
                            <div id="file4-status" class="file-upload-status"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8 mb-3">
                            <label for="file5" class="form-label">Финансовая отчетность (PDF)</label>
                            <input type="file" class="form-control" id="file5" name="file5" accept=".pdf" required onchange="updateStatus(this, 'file5-status')">
                        </div>
                        <div class="col" style="margin-top: 3%;">
                            <div id="file5-status" class="file-upload-status"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8 mb-3">
                            <label for="file6" class="form-label">Сертификат СТ-КЗ (PDF)</label>
                            <input type="file" class="form-control" id="file6" name="file6" accept=".pdf" required onchange="updateStatus(this, 'file6-status')">
                        </div>
                        <div class="col" style="margin-top: 3%;">
                            <div id="file6-status" class="file-upload-status"></div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-8 mb-3">
                            <label for="file7" class="form-label">Прочее</label>
                            <input type="file" class="form-control" id="file7" name="file7" accept=".pdf">
                        </div>
                        <div class="col" style="margin-top: 3%;">
                            <div id="file7-status" class="file-upload-status"></div>
                        </div>
                    </div>
                </form>
            </div>
                <div class="col d-flex justify-content-center align-items-center" >
                    <div class="btn-send">
                        <button type="button" id="ajax-submit" class="btn btn-primary" disabled>Отправить</button>
                    </div>
                </div>
        </div>
        <div class="mt-5">
            <h3 style="color: red">
                * Обязательное к предоставлению
                Важно! Потенциальный поставщик несет полную ответственность за полноту и достоверность предлагаемой на рассмотрение документации

            </h3>
        </div>
    </div>
    <div class="footer mt-5">
        <div class="row">
            <div class="col-8" style="margin-top: 1%; margin-left: 1%; color: white">
                <h5>KMG PetroChem LLP, 2024</h5>
            </div>
            <div class="col" style="margin-top: 1%; margin-left: 1%;">
                <a href="https://screenreader.tilqazyna.kz/#download" style="color: white; text-decoration: none; font-size: 20px">Экран дикторы</a>
            </div>
            <div class="col">
                <div class="social-icons">
                    <a href="https://www.tiktok.com/@kmgpetrochem" target="_blank" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.facebook.com/people/KMG-PetroChem/100095359480493/" target="_blank" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://www.instagram.com/kmg_petrochem_llp/" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://t.me/kmgpetrochem/" target="_blank" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
                    <a href="https://www.linkedin.com/company/kmg-petrochem/mycompany/?viewAsMember=true" target="_blank" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
