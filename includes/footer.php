        </div><!-- end main-content -->
    </div><!-- end wrapper -->

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Simple active menu handler
        const currentPath = window.location.pathname.split('/').pop();
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const itemPath = item.getAttribute('href');
            if (currentPath === itemPath) {
                menuItems.forEach(m => m.classList.remove('active'));
                item.classList.add('active');
            }
        });
    </script>
</body>
</html>
