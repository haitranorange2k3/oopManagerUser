<?php
if (!defined('_CODE')) {
    die('Access denied.....');
}

layouts('header');
?>


<header class="p-3 mb-3 border-bottom">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="?module=home&&action=dashboard" class="nav-link px-2 link-secondary">Home</a></li>
          <li><a href="?module=users&&action=list" class="nav-link px-2 link-body-emphasis">Manager User</a></li>
        </ul>

        <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search">
          <input type="search" class="form-control" placeholder="Search..." aria-label="Search">
        </form>

        <div class="dropdown text-end">
          <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle show" data-bs-toggle="dropdown" aria-expanded="true">
            <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
          </a>
          <ul class="dropdown-menu text-small show" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 34px);">
            <li><a class="dropdown-item" href="#">Cai dat</a></li>
            <li><a class="dropdown-item" href="#">Thong tin ca nhan</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="?module=auth&&action=logout">Dang xuat</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>