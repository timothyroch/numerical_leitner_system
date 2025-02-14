<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card</title>
    <style>
        .card-container {
            margin-top: 15px;
            padding: 10px;
            background-color: #f5f5f5; /* Light gray */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 100%;
            box-sizing: border-box;
        }

        .card-content {
            display: flex;
            flex-direction: row; /* Stack items vertically on small screens */
            align-items: center;
            justify-content: space-between;
        }

        .card-name {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .card-name:hover {
            color: #0078d4; 
        }

        .card-actions {
            font-size: 14px;
            display: flex;
            flex-wrap: wrap; 
            gap: 5px;
        }

        .card-actions a svg{
            margin-right: 8px; 
            vertical-align: middle; 
        }

        .card-link {
            display:flex;
            align-items:center;
            margin-right: 20px;
            text-decoration: none;
            color: white;
            background-color: #0078d4;
            padding: 7px;
            border-radius: 4px;
        }

        .card-link:hover {
            opacity:70%;
        }

        .card-actions span {
            color: #333;
        }

        /* Responsive adjustments */
        @media (max-width: 900px) {
            .card-content {
            display: flex;
            flex-direction: column; /* Stack items vertically on small screens */
            align-items: flex-start;
        }
            .card-name {
                font-size: 16px; /* Adjust font size for small screens */
            }

            .card-actions {
                font-size: 12px; /* Adjust font size for small screens */
            }
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-content">
            <a href="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($system['name'])); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=<?php echo urlencode(base64_encode($system['id'])); ?>" class="card-name">
                <?php echo htmlspecialchars($system['name']); ?>
            </a>

            <div class="card-actions">
                <a href="gametransiton.php?8e7d1f4b3a9c2e6a5f8b0d4c7a1e9f3b=<?php echo urlencode(base64_encode($system['name'])); ?>&d2f4a7c9e8b0d1a6c3e5f7b9a4d2e8c1=<?php echo urlencode(base64_encode($system['id'])); ?>" class="card-link" style="background-color:#008080;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>
                Play</a>

                
                <a href="view_system.php?YzRlYjFhMDYxY2ZjYmQzZTYxZmY5M2Y1YmQzNTM3NzI=<?php echo urlencode(base64_encode($system['name'])); ?>&f4e8d9a4b2c1d4e5f6a7b8c9d0e1f2a3=<?php echo urlencode(base64_encode($system['id'])); ?>" class="card-link" style="background-color:#BC8F8F;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>
                Modify</a>

                
                <a href="verify_delete_system.php?7f4b9d2e3c8a1f0e9d7a4b3c6e8d9f7b=<?php echo urlencode(base64_encode($system['name'])); ?>&a5c3e1b8d2f4a9c7b6d0e2a4f8c9b3d1=<?php echo urlencode(base64_encode($system['id'])); ?>" class="card-link" style="background-color:#CD5C5C;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                Remove</a>
            </div>
        </div>
    </div>
</body>
</html>
