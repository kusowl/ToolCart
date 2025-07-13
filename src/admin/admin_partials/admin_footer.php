</div>
</div>
<script src=<?=BASE_URL."assets/js/popup.js"?>></script>
<script src="<?=BASE_URL?>assets/js/flowbite.min.js"></script>
<script src="<?=BASE_URL?>assets/js/button.js"></script>
<script src="<?=BASE_URL?>assets/js/popup.js"></script>
<script src="<?=BASE_URL?>assets/ajax/cart.js"></script>
<script src="<?=BASE_URL?>assets/ajax/checkout.js"></script>
<script>
    function toggle(el) {
        if (el.style.display == 'none') {
            el.style.display = '';
        } else {
            el.style.display = 'none';
        }
    }

    const sidebar =  document.getElementById('sidebar')
    document.getElementById('sidebar-toggle').addEventListener('click', () => {toggle(sidebar)})
</script>
</body>
</html>