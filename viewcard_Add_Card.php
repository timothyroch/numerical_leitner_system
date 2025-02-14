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

            <a href="visitinfo_card.php?A3K7N1T9L5J8X2R6M4=<?php echo base64_encode($card['namecard']); ?>&G9L4P8T1X7R2M5J3K6=<?php echo base64_encode($userid); ?>&V2K6N9T5L3J1X8R7M4=<?php echo base64_encode($username) ?>&D7R1L9T6J4K8X3M2Q5=<?php echo base64_encode($card['cardid']) ?>&H4K9N2T8L5J1X7R3M6=<?php echo base64_encode($card['question']); ?>&Y1L7P9T4J2K6X8R5M3=<?php echo base64_encode($card['answer']); ?>&M3K8N2T9L5J7X1R6Q4=<?php echo base64_encode($systemId) ?>&S7L9P1T4J6K8X2R5M3=<?php echo base64_encode($systemName); ?>" style="text-decoration: none; color: black; background-color: #DCDCDC; padding: 5px; border-radius: 3px; font-size: 12px; margin-right: 5px; display:flex; align-items:center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-binoculars"><path d="M10 10h4"/><path d="M19 7V4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v3"/><path d="M20 21a2 2 0 0 0 2-2v-3.851c0-1.39-2-2.962-2-4.829V8a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2z"/><path d="M 22 16 L 2 16"/><path d="M4 21a2 2 0 0 1-2-2v-3.851c0-1.39 2-2.962 2-4.829V8a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v11a2 2 0 0 1-2 2z"/><path d="M9 7V4a1 1 0 0 0-1-1H6a1 1 0 0 0-1 1v3"/></svg>    
            View card</a>
        </div>
    </div>
<?php } ?>
