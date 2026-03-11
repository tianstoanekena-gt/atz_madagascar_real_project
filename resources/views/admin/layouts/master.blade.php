<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="{{ asset('assets/images/logo.jpg') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/admin/dashboard.css') }}">
    <title>ATZ Dashboard</title>
</head>

<body>
    <x-sidebar />

    @yield('content')
</body>

<script src="https://kit.fontawesome.com/VOTRE_CODE_KIT.js" crossorigin="anonymous"></script>
<script src="https://cdn.tailwindcss.com"></script>

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        500: '#1e40af', // Bleu ATZ
                        600: '#1d4ed8',
                    },
                    secondary: {
                        500: '#dc2626', // Rouge ATZ
                    },
                    accent: {
                        500: '#eab308', // Jaune ATZ
                    }
                },
                fontFamily: {
                    sans: ['Inter', 'system-ui', 'sans-serif']
                }
            }
        }
    }
</script>

</html>
