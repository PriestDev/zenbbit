<?php require('../details.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="<?php echo NAME; ?>">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo "../uploads/".FAV; ?>" />
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo "../uploads/".FAV; ?>" />
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo "../uploads/".FAV; ?>" />
    
    <title><?php echo NAME; ?> - Admin Panel</title>

    <!-- Font Awesome for icons -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (local) -->
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons496d.css" rel="stylesheet">

    <!-- Bootstrap CSS (for collapse functionality) -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min496d.css" rel="stylesheet">

    <!-- Modern Admin CSS -->
    <link href="css/admin-modern.css" rel="stylesheet">

    <script>
        // Apply theme BEFORE page renders to prevent flash
        (function() {
            const savedTheme = localStorage.getItem('admin-theme') || 'light';
            
            // Apply to html immediately
            document.documentElement.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
            
            // Create and inject CSS for immediate application
            const style = document.createElement('style');
            if (savedTheme === 'dark') {
                style.textContent = `
                    html, html body {
                        --bg-primary: #0f0f0f;
                        --bg-secondary: #1a1a1a;
                        --text-primary: #f3f4f6;
                        --text-secondary: #9ca3af;
                        --border-color: #333333;
                    }
                `;
            }
            if (style.textContent) {
                document.head.appendChild(style);
            }
        })();
    </script>
    <style>
        /* Fallback to ensure main content is visible if JS fails */
        #content{display:block!important; visibility:visible!important; color:var(--text-primary); background-color:var(--bg-primary);}
        
        /* Collapse/Accordion Styles for Sidebar Navigation */
        .collapse {
            display: none !important;
            overflow: hidden;
            visibility: hidden;
        }
        .collapse.show {
            display: block !important;
            visibility: visible !important;
            overflow: visible !important;
        }
        
        .collapse.show .collapse-item {
            display: block !important;
            visibility: visible !important;
        }
        
        .collapse-item {
            display: block !important;
            visibility: visible;
            padding: 0.75rem 1.5rem 0.75rem 2.5rem !important;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9rem;
            border-left: 3px solid transparent;
            transition: all 0.2s ease;
        }
        
        .collapse-item:hover {
            color: var(--text-primary);
            background-color: var(--bg-secondary);
            padding-left: 2.7rem;
            border-left-color: var(--primary-color, #622faa);
        }
        
        .collapse-item i {
            margin-right: 0.5rem;
            font-size: 0.85rem;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper (manages layout for header, sidebar, content, footer) -->
        <div id="content-wrapper">
