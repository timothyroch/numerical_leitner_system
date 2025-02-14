<?php
?>
<div class="card-container">
    <div class="card-content">
        <a href="visitview_system.php?Z5N1R8L3T7J4K9X2M6=<?php echo urlencode(base64_encode($system['name'])); ?>&B7Q3P9F2L6T1X8R4M5=<?php echo base64_encode($system['id']); ?>&Y8K2N4T9L5J1X3R6M7=<?php echo base64_encode($userid); ?>&C6R1L9T4J2K8X7M3Q5=<?php echo base64_encode($username); ?>" class="card-name">
            <?php echo htmlspecialchars($system['name']); ?>
        </a>
        <div class="card-actions">


            <a href="visitplay.php?G4K8N1T7L3J9X2R5M6=<?php echo urlencode(base64_encode($system['name'])); ?>&H7L3P9F1T6X8R2M4J5=<?php echo base64_encode($system['id']); ?>&V8K2N5T9L4J1X3R7M6=<?php echo base64_encode($userid); ?>&B6R1L8T4J3K9X7M2Q5=<?php echo base64_encode($username); ?>" class="card-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-play"><polygon points="6 3 20 12 6 21 6 3"/></svg>    
            Play</a>
            


            <a href="visitview_system.php?Z5N1R8L3T7J4K9X2M6=<?php echo urlencode(base64_encode($system['name'])); ?>&B7Q3P9F2L6T1X8R4M5=<?php echo base64_encode($system['id']); ?>&Y8K2N4T9L5J1X3R6M7=<?php echo base64_encode($userid); ?>&C6R1L9T4J2K8X7M3Q5=<?php echo base64_encode($username); ?>" class="card-link">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-binoculars"><path d="M10 10h4"/><path d="M19 7V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3"/><path d="M20 21a2 2 0 0 0 2-2v-3.851c0-1.39-2-2.962-2-4.829V8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2z"/><path d="M 22 16 L 2 16"/><path d="M4 21a2 2 0 0 1-2-2v-3.851c0-1.39 2-2.962 2-4.829V8a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2z"/><path d="M9 7V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v3"/></svg>    
            View Cards</a>

        </div>
    </div>
</div>

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
        .card-actions a{
            display:flex;
            align-items:center;
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
