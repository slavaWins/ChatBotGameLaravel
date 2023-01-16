<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light  " style="font-size: 14px;">
    <!-- Container wrapper -->

    <div class="container-fluid  ">
        <!-- Toggle button -->


        <button
            class="navbar-toggler"
            type="button"
            data-mdb-toggle="collapse"
            data-mdb-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Navbar brand -->


            <div class=" col-auto   px-0" style="   margin-top: -6px; ">

                <img
                    src="/img/Logo.png"
                    height="24"
                    alt="MDB Logo"
                    loading="lazy"
                />
            </div>

            <!-- Left links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0    ">


                <li class="nav-item  ">
                    <a class="nav-link" href="{{ route("project.show", $project) }}"> < К проекту
                    </a>
                </li>


            </ul>
        </div>

        <div class="d-flex align-items-center">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0    ">


                <li class="nav-item  p-1 ">
                    <a class="    btn btn-primary btnEditorSaveChange" style="display: none;"  > Сохранить
                        изменения </a>
                </li>

                <li class="nav-item p-1 ">
                    <a class="  btn btn-outline-dark" href="{{ route("project.show", $project) }}"> Просмотр </a>
                </li>


            </ul>
        </div>
        <!-- Right elements -->
    </div>
    <!-- Container wrapper -->
</nav>

