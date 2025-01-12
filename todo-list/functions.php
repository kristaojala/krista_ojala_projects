<?php
function generatePost($id, $post){
    $checked = isset($post['completed']) && $post['completed'] ? 'checked' : '';
    $completedClass = $post['completed'] ? 'completed' : '';
    
    $html = "<li id='post-$id' class='$completedClass'>
                <input type='checkbox' 
                       hx-get='update.php?post=$id&completed=" . ($post['completed'] ? '0' : '1') . "' 
                       hx-trigger='change' 
                       hx-target='#post-$id' 
                       hx-swap='outerHTML' 
                       $checked>
                <span>" . htmlspecialchars($post['text']) . "</span>
                <button hx-delete='delete.php?post=$id' 
                        hx-target='closest li'
                        hx-confirm='Are you sure you want to delete?'
                        hx-swap='outerHTML'>Remove</button>
              </li>";

    return $html;
}
