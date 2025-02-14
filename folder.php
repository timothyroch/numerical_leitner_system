<?php // PHP logic and includes ?>

<div class="folder-container">
    <div class="folder-name">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0078d7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-folder"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"/></svg>    
    <?php echo htmlspecialchars($folder['foldername']); ?></div>


    <form action="Add_System.php" class="formprivate" method="post">
        <input type="hidden" name="folder_visibility" value="<?php echo $folder['folderid']; ?>">
        <input type="checkbox" id="visibility-<?php echo $folder['folderid']; ?>" name="visibility" <?php echo $folder['visibility'] ? 'checked' : ''; ?>>
        <label for="visibility-<?php echo $folder['folderid']; ?>">Private</label>
        <span class="info-icon" title="Private mode will make your folder invisible to visitors.">i</span>

        <input type="submit" class="privateupdate" value="Update">
        <a href="verify_delete_folder.php?C7K9N4T2L8J5X1R6M3=<?php echo urlencode(base64_encode($folder['folderid'])); ?>&W1L5P8T3J7K9X2R4M6=<?php echo urlencode(base64_encode($folder['foldername'])); ?>" class="delete">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2" style="margin-right: 5px;">
                <path d="M3 6h18"/>
                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                <line x1="10" x2="10" y1="11" y2="17"/>
                <line x1="14" x2="14" y1="11" y2="17"/>
            </svg>
            Delete
        </a>
    </form>











    <button id="add-system-button-<?php echo $folder['folderid']; ?>" class="add-system-button" onclick="toggleSystemPopup(<?php echo $folder['folderid']; ?>)">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
    Add a System
</button>

    <div id="popup2-<?php echo $folder['folderid']; ?>" class="popup2">
        <h3>Create Your New System in <?php echo htmlspecialchars($folder['foldername']); ?></h3>
        <form method="post" action="Add_System.php">
            <input type="hidden" name="folderid" value="<?php echo $folder['folderid']; ?>">
            <input type="text" placeholder="Type here..." name="systemname" value="<?php echo htmlspecialchars($name); ?>">
            <button type="submit">Create</button>
        </form>
        <button onclick="toggleSystemPopup(<?php echo $folder['folderid']; ?>)">Cancel</button>
    </div>


    <?php
    if (is_array($systems) && !empty($systems)) {
        foreach ($systems as $system) {
            if ($system['folderid'] == $folder['folderid']) {
                include("card.php");
            }
        }
    } else {
        echo "<div class='no-systems'>Folder's empty</div>";
    }
    ?>



</div>

<style>

.delete {
    color: white;
    font-size: 15px;
    text-decoration: none;
    background-color: #8B0000;
    border-radius: 4px;
    padding: 6px 12px; 
    display: flex;
    align-items: center;
    text-align: center;
}
    .delete:hover{
        opacity: 70%;
        color: white;
    font-size: 15px;
    text-decoration: none;
    background-color: red;
    border-radius: 4px;
    padding: 6px 12px; 
    display: flex;
    align-items: center;
    text-align: center;
    }
    .formprivate {
    position: absolute;
    top: 1%;
    right: 1%;
    display: flex;
    align-items: center;
    gap: 10px; 
    background-color: #fff; 
    padding: 5px; 
    border-radius: 4px; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
}
.privateupdate {
    background-color: #0078d4;
    color: #fff;
    padding: 6px 12px; 
    border: 1px solid #0078d4;
    border-radius: 4px;
    display: inline-block; 
}
    .privateupdate:hover {
        opacity: 70%;
        background-color: #0078d4;
    color: #fff;
    padding: 6px 12px; 
    border: 1px solid #0078d4;
    border-radius: 4px;
    display: inline-block;
    }
    .folder-container {
        margin-top: 20px;
        padding: 20px;
        background-color: #ffffff; 
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
    background-color: #0078d4;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 14px;
    cursor: pointer;
    border-radius: 5px;
    margin-bottom: 20px;
    transition: background-color 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center; 
}
.add-system-button svg {
    margin-right: 8px; 
    vertical-align: middle; 
}

    .add-system-button:hover {
        background-color: #005a9e; 
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
        transition: background-color 0.1s ease;
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

    

    .info-icon {
            font-size: 18px;
            color: #007bff;
            cursor: pointer;
            border: 1px solid #007bff;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            text-align: center;
            line-height: 18px;
            display: inline-block;
            position: relative;
        }

        .info-icon::after {
            content: '';
            visibility: hidden;
            width: 200px;
          
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            top: 125%;
            left: 50%;
            transform: translateX(-50%);
            opacity: 0;
            transition: opacity 0s;
            z-index: 1;
            white-space: nowrap;
        }

        .info-icon::after::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        .info-icon:hover::after {
            visibility: visible;
            opacity: 1;
        }

        @media (max-width: 768px) {
            .folder-name{
                margin-top: 40px;
            }
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