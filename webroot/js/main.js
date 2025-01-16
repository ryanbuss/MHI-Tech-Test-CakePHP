document.querySelectorAll('.delete-btn').forEach(button => {
    button.onclick = function(e) {

        e.preventDefault();

        if (confirm("Are you sure you want to delete: "+this.getAttribute('data-name')+"?")) {
            
            window.location.href = this.getAttribute('data-url');
        }
    };
});