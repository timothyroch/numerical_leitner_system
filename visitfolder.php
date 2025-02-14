<?php // PHP logic and includes ?>

<div class="folder-container">
    <div class="folder-name">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0078d7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>     
    <?php echo htmlspecialchars($folder['foldername']); ?></div>
    
    <?php
    if (is_array($systems) && !empty($systems)) {
        foreach ($systems as $system) {
            if ($system['folderid'] == $folder['folderid']) {
                include("visitsystem.php");
            }
        }
    } else {
        echo "<div class='no-systems'>Folder's empty</div>";
    }
    ?>
</div>


<style>
    .folder-container {
        margin-top: 20px;
        padding: 20px;
        background-color: #ffffff; /* White background for clarity */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
    }

    .folder-name {
        font-size: 20px;
        font-weight: bold;
        color: #0078d4;
        margin-bottom: 10px;
        display:flex;
        align-items:center;
    }
    .folder-name svg{
        margin-right: 8px; 
        vertical-align: middle; 
    }

    .add-system-button {
        background-color: #0078d4; /* Microsoft Blue */
        color: white;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        cursor: pointer;
        border-radius: 5px;
        margin-bottom: 20px;
        transition: background-color 0.3s ease;
    }

    .add-system-button:hover {
        background-color: #005a9e; /* Darker Blue on hover */
    }

    .popup2 {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        padding: 20px;
        box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        border-radius: 8px;
        display: none;
        z-index: 1000;
        width: 350px;
        transition: opacity 0.3s ease;
    }

    .popup2 h3 {
        margin-top: 0;
        font-size: 22px;
        font-weight: bold;
        color: #0078d4;
        margin-bottom: 15px;
    }

    .popup2 input[type="text"],
    .popup2 button {
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    .popup2 button[type="submit"] {
        background-color: #0078d4;
        color: white;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .popup2 button[type="submit"]:hover {
        background-color: #005a9e;
    }

    .popup2 button[type="button"] {
        background-color: #ddd;
        color: #333;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .popup2 button[type="button"]:hover {
        background-color: #ccc;
    }

    .no-systems {
        text-align: center;
        color: #888;
        font-size: 18px;
        margin-top: 20px;
    }
</style>

<script>
    function toggleSystemPopup(folderId) {
        var popup = document.getElementById('popup2-' + folderId);
        if (popup.style.display === 'none' || popup.style.display === '') {
            popup.style.display = 'block';
        } else {
            popup.style.display = 'none';
        }
    }
</script>
