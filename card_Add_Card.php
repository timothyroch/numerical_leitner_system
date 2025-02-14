<?php if (isset($card)) { ?>
    <br>
    <div id="post" style="height: auto; width: 93%; background-color: #DCDCDC; padding: 10px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div>
            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                <strong>Name:</strong> <?php echo htmlspecialchars($card['namecard']); ?>
            </div>
            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                <strong>Question:</strong> <?php echo htmlspecialchars($card['question']); ?>
            </div>
            <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                <strong>Answer:</strong> <?php echo htmlspecialchars($card['answer']); ?>
            </div>
        </div>
        <div style="display: flex; justify-content: flex-end; margin-top: 10px;">



        <a href="delete_card.php?d2a8b5c6=<?php echo base64_encode($card['cardid']); ?>&f3e1d7a2=<?php echo base64_encode($card['level']); ?>&a5b9c3e7=<?php echo base64_encode($systemName); ?>&c6d4e8f1=<?php echo base64_encode($systemId); ?>" class="deletecard" style="text-decoration: none; color: white; background-color: #8B0000; padding: 5px; border-radius: 3px; margin-right: 10px; font-size: 11px; display:flex; align-items:center;">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
        Delete</a>




            <a href="info_card.php?8f0a1c9d=<?php echo base64_encode($card['namecard']); ?>&f7d1b3a4=<?php echo base64_encode($card['cardid']); ?>&e3c5d7b6=<?php echo base64_encode($card['question']); ?>&d2a4f8b1=<?php echo base64_encode($card['answer']); ?>&c9b3e7f2=<?php echo base64_encode($systemId); ?>&a6c8d1f5=<?php echo base64_encode($systemName); ?>" style="text-decoration: none; color: black; background-color: #DCDCDC; padding: 5px; border-radius: 3px; font-size: 11px; margin-right: 5px; display:flex;align-items:center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg>    
            Modify</a>




            <a href="level_down.php?e1f7b6d9=<?php echo base64_encode($card['cardid']); ?>&c3d8e5f2=<?php echo base64_encode($card['level']); ?>&a7b9c4d8=<?php echo base64_encode($systemName); ?>&b1e3f5d6=<?php echo base64_encode($systemId); ?>" class="cardlevel" style="text-decoration: none; color: black; background-color: #DCDCDC; padding: 5px; border-radius: 3px; font-size: 11px; margin-right: 5px; display:flex; align-items:center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-down"><path d="M12 5v14"/><path d="m19 12-7 7-7-7"/></svg>    
            Level Down</a>

            <a href="level_up.php?f8d7a9b3=<?php echo base64_encode($card['cardid']); ?>&a2e1c5d8=<?php echo base64_encode($card['level']); ?>&b9f3e2d4=<?php echo base64_encode($systemName); ?>&c7a8b6d5=<?php echo base64_encode($systemId); ?>" class="cardlevel" style="text-decoration: none; color: black; background-color: #DCDCDC; padding: 5px; border-radius: 3px; font-size: 11px; display:flex; align-items:center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up"><path d="m5 12 7-7 7 7"/><path d="M12 19V5"/></svg>    
            Level Up</a>
        </div>
    </div>
<?php } ?>
