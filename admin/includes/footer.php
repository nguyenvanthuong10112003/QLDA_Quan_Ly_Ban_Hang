                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="../assets/js/datatables-simple-demo.js"></script>
        <script src="../assets/js/sweetalert2.all.min.js"></script>
        <script src="../assets/js/jquery-3.7.1.min.js"></script>
        <script src="../assets/js/delete_alert.js"></script>
        <script src="../assets/js/checkbox.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
        <script src="../assets/js/date.js"></script>
        <script src="../assets/js/toastr.min.js"></script>
        <script src="../assets/js/toastr.js"></script>
        <script>
            <?php if (isset($_SESSION['message'])) : ?>
                <?php
                    $message = flash('message');
                    $message_type = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'success';
                ?>
                toastr.<?php echo $message_type; ?>("<?php echo $message; ?>");
            <?php endif; ?>
        </script>
    </body>
</html>