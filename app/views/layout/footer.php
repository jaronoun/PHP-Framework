
<div class="b-example-divider"></div>
<footer class="bg-light text-center text-lg-start d-block d-md-none">
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-bottom d-lg-none">
        <div class="container-fluid">
            <ul class="navbar-nav justify-content-between w-100">
                <ul class="navbar-nav justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link" href="/cijfers">
                            <?php echo $page == 'grades' ? '<b>Cijfers</b>' : 'Cijfers'; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/tentamens">
                            <?php echo $page == 'exams' ? '<b>Tentamens</b>' : 'Tentamens'; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/profiel">
                            <?php echo $page == 'users' ? '<b>Profiel</b>' : 'Profiel'; ?>
                        </a>
                    </li>
                </ul>
            </ul>
        </div>
    </nav>
</footer>


