<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Note Everyday</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #4CAF50;
            font-size: 2.5em;
            text-align: center;
        }
        nav {
            margin-bottom: 20px;
            text-align: center;
        }
        a {
            margin-right: 15px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 1.1em;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:hover {
            background-color: #e8f5e9;
        }
        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <h1>Note Everyday</h1>
    <nav>
        <a href="index.php">Dashboard</a>
        <a href="create.php">Add Note</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>