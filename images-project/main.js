
function showConfirmationModal(event){
//jos path on suggested-images, lopetetaan suoritus
//if path is suggested-images, stop
    if(event.detail.path === 'suggested-images.php'){
        return;    
    }
    event.preventDefault();

    //event's action
   const action = event.detail.elt.dataset.action; 

    //modal for confirmation
    const confirmationModal = `
        <dialog class="modal">
            <div id="confirmation">
                <h2>Are you Sure?</h2>
                <p>Do you really want to ${action} this picture?</p>
                <div id="confirmation-actions">
                    <button id="action-no" class="button-text">No</button>
                    <button id="action-yes" class="button-text ${action}">Yes</button>
                </div>
            </div>
        </dialog>
    `;

    document.body.insertAdjacentHTML('beforeend', confirmationModal);
    const dialog = document.querySelector('dialog');

    const noBtn = document.getElementById('action-no');
    noBtn.addEventListener('click', function(){
        dialog.remove();
    })

    const yesBtn = document.getElementById('action-yes');
    yesBtn.addEventListener('click', function(){
        event.detail.issueRequest();
        dialog.remove();
    })
   

    dialog.showModal();

}

document.addEventListener('htmx:confirm', showConfirmationModal);

document.getElementById('suggested-images').addEventListener('htmx:afterRequest', function(event){
    if(event.detail.pathInfo.requestPath !== 'suggested-images.php'){
        console.log(event.detail.pathInfo.requestPath)
        return; 
    }else{
        console.log(event.detail.pathInfo.requestPath);
    }
    
//reset animation of the bar
//resetoi palkin animaation
const loadingDiv = document.getElementById('loading');
loadingDiv.style.animation = 'none';
loadingDiv.offsetHeight; 
loadingDiv.style.animation = null; 
});

