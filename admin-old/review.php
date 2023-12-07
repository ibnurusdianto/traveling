<?php
$session_expire_time = 600;
session_set_cookie_params($session_expire_time);
session_start();

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $session_expire_time)) {
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit;
}

$_SESSION['last_activity'] = time();

if (isset($_SESSION['username'])) {
    $conn = mysqli_connect('localhost', 'root', '', 'travel');
    $username = mysqli_real_escape_string($conn, $_SESSION['username']);
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 's', $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        session_unset();
        session_destroy();
        header("Location: ../login.php");
        exit;
    } else {
        $row = mysqli_fetch_assoc($result);

        if ($row['role'] != 'admin') {
            header("Location: ../index.php");
            exit;
        }
    }
}

include "connection.php";

$query = "SELECT r.id, r.komentar, r.rating, u.username, t.nama_tempat 
          FROM review r
          JOIN user u ON r.user_id = u.id
          JOIN tempat_wisata t ON r.tempat_wisata_id = t.id";
$datareview = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review</title>
    <link rel="icon" type="image/x-icon" href="favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/perfect-scrollbar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <link rel="stylesheet" href="assets/css/highlight.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/style.css" />
    <link defer rel="stylesheet" type="text/css" media="screen" href="assets/css/animate.css" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="assets/js/perfect-scrollbar.min.js"></script>
    <script defer src="assets/js/popper.min.js"></script>
    <script defer src="assets/js/tippy-bundle.umd.min.js"></script>
    <script defer src="assets/js/sweetalert.min.js"></script>
</head>

<body x-data="main" class="relative font-nunito text-sm font-normal antialiased" :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme, $store.app.menu, $store.app.layout,$store.app.rtlClass]">
    <!-- sidebar menu overlay -->
    <div x-cloak class="fixed inset-0 z-50 bg-[black]/60 lg:hidden" :class="{'hidden' : !$store.app.sidebar}" @click="$store.app.toggleSidebar()"></div>

    <!-- screen loader -->
    <div class="screen_loader animate__animated fixed inset-0 z-[60] grid place-content-center bg-[#fafafa] dark:bg-[#060818]">
        <svg width="64" height="64" viewBox="0 0 135 135" xmlns="http://www.w3.org/2000/svg" fill="#4361ee">
            <path d="M67.447 58c5.523 0 10-4.477 10-10s-4.477-10-10-10-10 4.477-10 10 4.477 10 10 10zm9.448 9.447c0 5.523 4.477 10 10 10 5.522 0 10-4.477 10-10s-4.478-10-10-10c-5.523 0-10 4.477-10 10zm-9.448 9.448c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10zM58 67.447c0-5.523-4.477-10-10-10s-10 4.477-10 10 4.477 10 10 10 10-4.477 10-10z">
                <animateTransform attributeName="transform" type="rotate" from="0 67 67" to="-360 67 67" dur="2.5s" repeatCount="indefinite" />
            </path>
            <path d="M28.19 40.31c6.627 0 12-5.374 12-12 0-6.628-5.373-12-12-12-6.628 0-12 5.372-12 12 0 6.626 5.372 12 12 12zm30.72-19.825c4.686 4.687 12.284 4.687 16.97 0 4.686-4.686 4.686-12.284 0-16.97-4.686-4.687-12.284-4.687-16.97 0-4.687 4.686-4.687 12.284 0 16.97zm35.74 7.705c0 6.627 5.37 12 12 12 6.626 0 12-5.373 12-12 0-6.628-5.374-12-12-12-6.63 0-12 5.372-12 12zm19.822 30.72c-4.686 4.686-4.686 12.284 0 16.97 4.687 4.686 12.285 4.686 16.97 0 4.687-4.686 4.687-12.284 0-16.97-4.685-4.687-12.283-4.687-16.97 0zm-7.704 35.74c-6.627 0-12 5.37-12 12 0 6.626 5.373 12 12 12s12-5.374 12-12c0-6.63-5.373-12-12-12zm-30.72 19.822c-4.686-4.686-12.284-4.686-16.97 0-4.686 4.687-4.686 12.285 0 16.97 4.686 4.687 12.284 4.687 16.97 0 4.687-4.685 4.687-12.283 0-16.97zm-35.74-7.704c0-6.627-5.372-12-12-12-6.626 0-12 5.373-12 12s5.374 12 12 12c6.628 0 12-5.373 12-12zm-19.823-30.72c4.687-4.686 4.687-12.284 0-16.97-4.686-4.686-12.284-4.686-16.97 0-4.687 4.686-4.687 12.284 0 16.97 4.686 4.687 12.284 4.687 16.97 0z">
                <animateTransform attributeName="transform" type="rotate" from="0 67 67" to="360 67 67" dur="8s" repeatCount="indefinite" />
            </path>
        </svg>
    </div>

    <!-- scroll to top button -->
    <div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
        <template x-if="showTopButton">
            <button type="button" class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary" @click="goToTop">
                <svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" fill-rule="evenodd" clip-rule="evenodd" d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z" fill="currentColor" />
                    <path d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z" fill="currentColor" />
                </svg>
            </button>
        </template>
    </div>

    <!-- start theme customizer section -->
    <div x-data="customizer">
        <div class="fixed inset-0 z-[51] hidden bg-[black]/60 px-4 transition-[display]" :class="{'!block': showCustomizer}" @click="showCustomizer = false"></div>

        <nav class="fixed top-0 bottom-0 z-[51] w-full max-w-[400px] bg-white p-4 shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-[right] duration-300 ltr:-right-[400px] rtl:-left-[400px] dark:bg-[#0e1726]" :class="{'ltr:!right-0 rtl:!left-0' : showCustomizer}">
            <a href="javascript:;" class="absolute top-0 bottom-0 my-auto flex h-10 w-12 cursor-pointer items-center justify-center bg-primary text-white ltr:-left-12 ltr:rounded-tl-full ltr:rounded-bl-full rtl:-right-12 rtl:rounded-tr-full rtl:rounded-br-full" @click="showCustomizer = !showCustomizer">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-[spin_3s_linear_infinite]">
                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5" />
                    <path opacity="0.5" d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z" stroke="currentColor" stroke-width="1.5" />
                </svg>
            </a>
            <div class="perfect-scrollbar h-full">
                <div class="relative pb-5 text-center">
                    <a href="javascript:;" class="absolute top-0 opacity-30 hover:opacity-100 ltr:right-0 rtl:left-0 dark:text-white" @click="showCustomizer = false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </a>
                    <h4 class="mb-1 dark:text-white">TEMPLATE CUSTOMIZER</h4>
                    <p class="text-white-dark">Set preferences that will be cookied for your live preview demonstration.</p>
                </div>
                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Color Scheme</h5>
                    <p class="text-xs text-white-dark">Overall light or dark presentation.</p>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <button type="button" class="btn" :class="[$store.app.theme === 'light' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleTheme('light')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5"></circle>
                                <path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                            Light
                        </button>
                        <button type="button" class="btn" :class="[$store.app.theme === 'dark' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleTheme('dark')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                <path d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z" fill="currentColor"></path>
                            </svg>
                            Dark
                        </button>
                        <button type="button" class="btn" :class="[$store.app.theme === 'system' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleTheme('system')">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                                <path d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z" stroke="currentColor" stroke-width="1.5"></path>
                                <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                                <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                            </svg>
                            System
                        </button>
                    </div>
                </div>

                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Navigation Position</h5>
                    <p class="text-xs text-white-dark">Select the primary navigation paradigm for your app.</p>
                    <div class="mt-3 grid grid-cols-3 gap-2">
                        <button type="button" class="btn" :class="[$store.app.menu === 'horizontal' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleMenu('horizontal')">
                            Horizontal
                        </button>
                        <button type="button" class="btn" :class="[$store.app.menu === 'vertical' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleMenu('vertical')">
                            Vertical
                        </button>
                        <button type="button" class="btn" :class="[$store.app.menu === 'collapsible-vertical' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleMenu('collapsible-vertical')">
                            Collapsible
                        </button>
                    </div>
                    <div class="mt-5 text-primary">
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.semidark" type="checkbox" :value="true" class="form-checkbox" @change="$store.app.toggleSemidark()" />
                            <span>Semi Dark (Sidebar & Header)</span>
                        </label>
                    </div>
                </div>
                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Layout Style</h5>
                    <p class="text-xs text-white-dark">Select the primary layout style for your app.</p>
                    <div class="mt-3 flex gap-2">
                        <button type="button" class="btn flex-auto" :class="[$store.app.layout === 'boxed-layout' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleLayout('boxed-layout')">
                            Box
                        </button>
                        <button type="button" class="btn flex-auto" :class="[$store.app.layout === 'full' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleLayout('full')">
                            Full
                        </button>
                    </div>
                </div>
                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Direction</h5>
                    <p class="text-xs text-white-dark">Select the direction for your app.</p>
                    <div class="mt-3 flex gap-2">
                        <button type="button" class="btn flex-auto" :class="[$store.app.rtlClass === 'ltr' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleRTL('ltr')">
                            LTR
                        </button>
                        <button type="button" class="btn flex-auto" :class="[$store.app.rtlClass === 'rtl' ? 'btn-primary' :'btn-outline-primary']" @click="$store.app.toggleRTL('rtl')">
                            RTL
                        </button>
                    </div>
                </div>

                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Navbar Type</h5>
                    <p class="text-xs text-white-dark">Sticky or Floating.</p>
                    <div class="mt-3 flex items-center gap-3 text-primary">
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.navbar" type="radio" value="navbar-sticky" class="form-radio" @change="$store.app.toggleNavbar()" />
                            <span>Sticky</span>
                        </label>
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.navbar" type="radio" value="navbar-floating" class="form-radio" @change="$store.app.toggleNavbar()" />
                            <span>Floating</span>
                        </label>
                        <label class="mb-0 inline-flex">
                            <input x-model="$store.app.navbar" type="radio" value="navbar-static" class="form-radio" @change="$store.app.toggleNavbar()" />
                            <span>Static</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3 rounded-md border border-dashed border-[#e0e6ed] p-3 dark:border-[#1b2e4b]">
                    <h5 class="mb-1 text-base leading-none dark:text-white">Router Transition</h5>
                    <p class="text-xs text-white-dark">Animation of main content.</p>
                    <div class="mt-3">
                        <select x-model="$store.app.animation" class="form-select border-primary text-primary" @change="$store.app.toggleAnimation()">
                            <option value="">Select Animation</option>
                            <option value="animate__fadeIn">Fade</option>
                            <option value="animate__fadeInDown">Fade Down</option>
                            <option value="animate__fadeInUp">Fade Up</option>
                            <option value="animate__fadeInLeft">Fade Left</option>
                            <option value="animate__fadeInRight">Fade Right</option>
                            <option value="animate__slideInDown">Slide Down</option>
                            <option value="animate__slideInLeft">Slide Left</option>
                            <option value="animate__slideInRight">Slide Right</option>
                            <option value="animate__zoomIn">Zoom In</option>
                        </select>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <!-- end theme customizer section -->

    <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
        <!-- start sidebar section -->
        <div :class="{'dark text-white-dark' : $store.app.semidark}">
            <nav x-data="sidebar" class="sidebar fixed top-0 bottom-0 z-50 h-full min-h-screen w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] transition-all duration-300">
                <div class="h-full bg-white dark:bg-[#0e1726]">
                    <div class="flex items-center justify-between px-4 py-3">
                        <a href="index.html" class="main-logo flex shrink-0 items-center">
                            <img class="ml-[5px] w-8 flex-none" src="assets/images/logo.svg" alt="image" />
                            <span class="align-middle text-2xl font-semibold ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light lg:inline">VRISTO</span>
                        </a>
                        <a href="javascript:;" class="collapse-icon flex h-8 w-8 items-center rounded-full transition duration-300 hover:bg-gray-500/10 rtl:rotate-180 dark:text-white-light dark:hover:bg-dark-light/10" @click="$store.app.toggleSidebar()">
                            <svg class="m-auto h-5 w-5" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <ul class="perfect-scrollbar relative h-[calc(100vh-80px)] space-y-0.5 p-4 py-0 font-semibold" x-data="{ activeDropdown: 'datatables' }">
                        <li class="menu nav-item">
                            <a href="index.php" class="nav-link">
                                <div class="flex items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M22 22L2 22" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M3 22.0001V11.3472C3 10.4903 3.36644 9.67432 4.00691 9.10502L10.0069 3.77169C11.1436 2.76133 12.8564 2.76133 13.9931 3.77169L19.9931 9.10502C20.6336 9.67432 21 10.4903 21 11.3472V22.0001" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10 9H14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M9 15.5H15" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M9 18.5H15" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M18 22V16C18 14.1144 18 13.1716 17.4142 12.5858C16.8284 12 15.8856 12 14 12H10C8.11438 12 7.17157 12 6.58579 12.5858C6 13.1716 6 14.1144 6 16V22" stroke="#1C274C" stroke-width="1.5" />
                                    </svg>
                                    <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Dashboard</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu nav-item">
                            <a href="wisata.php" class="nav-link">
                                <div class="flex items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18 8.80745C18 13.7615 13.7333 15 11.6 15C9.73333 15 6 13.7615 6 8.80745C6 6.71017 7.20839 5.35826 8.26099 4.65274C8.79638 4.29388 9.48354 4.55201 9.57296 5.17624C9.75127 6.421 10.8777 7.34944 11.5596 6.27998C12.1424 5.36614 12.3529 4.13169 12.3529 3.38896C12.3529 2.28965 13.503 1.59108 14.4009 2.2646C16.1512 3.5774 18 5.776 18 8.80745Z" stroke="#1C274C" stroke-width="1.5" />
                                        <path d="M20 15L4 22" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M4 15L9 17.1875M20 22L14.5 19.5938" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M15 10C14.8 10.6667 13.92 12 12 12" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                    <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Wisata</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu nav-item">
                            <a href="kategori.php" class="nav-link">
                                <div class="flex items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.755 2H7.24502C6.08614 2 5.50671 2 5.03939 2.16261C4.15322 2.47096 3.45748 3.18719 3.15795 4.09946C3 4.58055 3 5.17705 3 6.37006V20.3742C3 21.2324 3.985 21.6878 4.6081 21.1176C4.97417 20.7826 5.52583 20.7826 5.8919 21.1176L6.375 21.5597C7.01659 22.1468 7.98341 22.1468 8.625 21.5597C9.26659 20.9726 10.2334 20.9726 10.875 21.5597C11.5166 22.1468 12.4834 22.1468 13.125 21.5597C13.7666 20.9726 14.7334 20.9726 15.375 21.5597C16.0166 22.1468 16.9834 22.1468 17.625 21.5597L18.1081 21.1176C18.4742 20.7826 19.0258 20.7826 19.3919 21.1176C20.015 21.6878 21 21.2324 21 20.3742V6.37006C21 5.17705 21 4.58055 20.842 4.09946C20.5425 3.18719 19.8468 2.47096 18.9606 2.16261C18.4933 2 17.9139 2 16.755 2Z" stroke="#1C274C" stroke-width="1.5" />
                                        <path d="M10.5 11L17 11" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M7 11H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M7 7.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M7 14.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10.5 7.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10.5 14.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                    <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Category</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu nav-item">
                            <a href="fasilitas.php" class="nav-link">
                                <div class="flex items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16 4.00195C18.175 4.01406 19.3529 4.11051 20.1213 4.87889C21 5.75757 21 7.17179 21 10.0002V16.0002C21 18.8286 21 20.2429 20.1213 21.1215C19.2426 22.0002 17.8284 22.0002 15 22.0002H9C6.17157 22.0002 4.75736 22.0002 3.87868 21.1215C3 20.2429 3 18.8286 3 16.0002V10.0002C3 7.17179 3 5.75757 3.87868 4.87889C4.64706 4.11051 5.82497 4.01406 8 4.00195" stroke="#1C274C" stroke-width="1.5" />
                                        <path d="M10.5 14L17 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M7 14H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M7 10.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M7 17.5H7.5" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10.5 10.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M10.5 17.5H17" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M8 3.5C8 2.67157 8.67157 2 9.5 2H14.5C15.3284 2 16 2.67157 16 3.5V4.5C16 5.32843 15.3284 6 14.5 6H9.5C8.67157 6 8 5.32843 8 4.5V3.5Z" stroke="#1C274C" stroke-width="1.5" />
                                    </svg>
                                    <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Fasilitas</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu nav-item">
                            <a href="user.php" class="nav-link">
                                <div class="flex items-center">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="6" r="4" stroke="#1C274C" stroke-width="1.5" />
                                        <path d="M18 9C19.6569 9 21 7.88071 21 6.5C21 5.11929 19.6569 4 18 4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M6 9C4.34315 9 3 7.88071 3 6.5C3 5.11929 4.34315 4 6 4" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <ellipse cx="12" cy="17" rx="6" ry="4" stroke="#1C274C" stroke-width="1.5" />
                                        <path d="M20 19C21.7542 18.6153 23 17.6411 23 16.5C23 15.3589 21.7542 14.3847 20 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M4 19C2.24575 18.6153 1 17.6411 1 16.5C1 15.3589 2.24575 14.3847 4 14" stroke="#1C274C" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                    <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">User</span>
                                </div>
                            </a>
                        </li>

                        <li class="menu nav-item">
                            <a href="review.php" class="nav-link active group">
                                <div class="flex items-center">
                                    <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                        <g id="SVGRepo_iconCarrier">
                                            <path d="M10.3 6.74a.75.75 0 01-.04 1.06l-2.908 2.7 2.908 2.7a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 011.06.04zm3.44 1.06a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.908-2.7-2.908-2.7z"></path>
                                            <path fill-rule="evenodd" d="M1.5 4.25c0-.966.784-1.75 1.75-1.75h17.5c.966 0 1.75.784 1.75 1.75v12.5a1.75 1.75 0 01-1.75 1.75h-9.69l-3.573 3.573A1.457 1.457 0 015 21.043V18.5H3.25a1.75 1.75 0 01-1.75-1.75V4.25zM3.25 4a.25.25 0 00-.25.25v12.5c0 .138.112.25.25.25h2.5a.75.75 0 01.75.75v3.19l3.72-3.72a.75.75 0 01.53-.22h10a.25.25 0 00.25-.25V4.25a.25.25 0 00-.25-.25H3.25z"></path>
                                        </g>
                                    </svg>
                                    <span class="text-black ltr:pl-3 rtl:pr-3 dark:text-[#506690] dark:group-hover:text-white-dark">Review</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end sidebar section -->

        <div class="main-content">
            <!-- start header section -->
            <header :class="{'dark' : $store.app.semidark && $store.app.menu === 'horizontal'}">
                <div class="shadow-sm">
                    <div class="relative flex w-full items-center bg-white px-5 py-2.5 dark:bg-[#0e1726]">
                        <div class="horizontal-logo flex items-center justify-between ltr:mr-2 rtl:ml-2 lg:hidden">
                            <a href="index.html" class="main-logo flex shrink-0 items-center">
                                <img class="inline w-8 ltr:-ml-1 rtl:-mr-1" src="assets/images/logo.svg" alt="image" />
                                <span class="hidden align-middle text-2xl font-semibold transition-all duration-300 ltr:ml-1.5 rtl:mr-1.5 dark:text-white-light md:inline">VRISTO</span>
                            </a>

                            <a href="javascript:;" class="collapse-icon flex flex-none rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary ltr:ml-2 rtl:mr-2 dark:bg-dark/40 dark:text-[#d0d2d6] dark:hover:bg-dark/60 dark:hover:text-primary lg:hidden" @click="$store.app.toggleSidebar()">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 7L4 7" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M20 12L4 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M20 17L4 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </a>
                        </div>
                        <div x-data="header" class="flex items-center space-x-1.5 ltr:ml-auto rtl:mr-auto rtl:space-x-reverse dark:text-[#d0d2d6] sm:flex-1 ltr:sm:ml-0 sm:rtl:mr-0 lg:space-x-2">
                            <div class="sm:ltr:mr-auto sm:rtl:ml-auto" x-data="{ search: false }" @click.outside="search = false">
                                <form class="absolute inset-x-0 top-1/2 z-10 mx-4 hidden -translate-y-1/2 sm:relative sm:top-0 sm:mx-0 sm:block sm:translate-y-0" :class="{'!block' : search}" @submit.prevent="search = false">
                                    <div class="relative">
                                        <input type="text" class="peer form-input bg-gray-100 placeholder:tracking-widest ltr:pl-9 ltr:pr-9 rtl:pr-9 rtl:pl-9 sm:bg-transparent ltr:sm:pr-4 rtl:sm:pl-4" placeholder="Search..." />
                                        <button type="button" class="absolute inset-0 h-9 w-9 appearance-none peer-focus:text-primary ltr:right-auto rtl:left-auto">
                                            <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5" />
                                                <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                        <button type="button" class="absolute top-1/2 block -translate-y-1/2 hover:opacity-80 ltr:right-2 rtl:left-2 sm:hidden" @click="search = false">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle opacity="0.5" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" />
                                                <path d="M14.5 9.50002L9.5 14.5M9.49998 9.5L14.5 14.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                                <button type="button" class="search_btn rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 dark:bg-dark/40 dark:hover:bg-dark/60 sm:hidden" @click="search = ! search">
                                    <svg class="mx-auto h-4.5 w-4.5 dark:text-[#d0d2d6]" width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5" />
                                        <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </button>
                            </div>
                            <div>
                                <a href="javascript:;" x-cloak x-show="$store.app.theme === 'light'" href="javascript:;" class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60" @click="$store.app.toggleTheme('dark')">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="5" stroke="currentColor" stroke-width="1.5" />
                                        <path d="M12 2V4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M12 20V22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M4 12L2 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path d="M22 12L20 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path opacity="0.5" d="M19.7778 4.22266L17.5558 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path opacity="0.5" d="M4.22217 4.22266L6.44418 6.25424" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path opacity="0.5" d="M6.44434 17.5557L4.22211 19.7779" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path opacity="0.5" d="M19.7778 19.7773L17.5558 17.5551" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </a>
                                <a href="javascript:;" x-cloak x-show="$store.app.theme === 'dark'" href="javascript:;" class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60" @click="$store.app.toggleTheme('system')">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M21.0672 11.8568L20.4253 11.469L21.0672 11.8568ZM12.1432 2.93276L11.7553 2.29085V2.29085L12.1432 2.93276ZM21.25 12C21.25 17.1086 17.1086 21.25 12 21.25V22.75C17.9371 22.75 22.75 17.9371 22.75 12H21.25ZM12 21.25C6.89137 21.25 2.75 17.1086 2.75 12H1.25C1.25 17.9371 6.06294 22.75 12 22.75V21.25ZM2.75 12C2.75 6.89137 6.89137 2.75 12 2.75V1.25C6.06294 1.25 1.25 6.06294 1.25 12H2.75ZM15.5 14.25C12.3244 14.25 9.75 11.6756 9.75 8.5H8.25C8.25 12.5041 11.4959 15.75 15.5 15.75V14.25ZM20.4253 11.469C19.4172 13.1373 17.5882 14.25 15.5 14.25V15.75C18.1349 15.75 20.4407 14.3439 21.7092 12.2447L20.4253 11.469ZM9.75 8.5C9.75 6.41182 10.8627 4.5828 12.531 3.57467L11.7553 2.29085C9.65609 3.5593 8.25 5.86509 8.25 8.5H9.75ZM12 2.75C11.9115 2.75 11.8077 2.71008 11.7324 2.63168C11.6686 2.56527 11.6538 2.50244 11.6503 2.47703C11.6461 2.44587 11.6482 2.35557 11.7553 2.29085L12.531 3.57467C13.0342 3.27065 13.196 2.71398 13.1368 2.27627C13.0754 1.82126 12.7166 1.25 12 1.25V2.75ZM21.7092 12.2447C21.6444 12.3518 21.5541 12.3539 21.523 12.3497C21.4976 12.3462 21.4347 12.3314 21.3683 12.2676C21.2899 12.1923 21.25 12.0885 21.25 12H22.75C22.75 11.2834 22.1787 10.9246 21.7237 10.8632C21.286 10.804 20.7293 10.9658 20.4253 11.469L21.7092 12.2447Z" fill="currentColor" />
                                    </svg>
                                </a>
                                <a href="javascript:;" x-cloak x-show="$store.app.theme === 'system'" href="javascript:;" class="flex items-center rounded-full bg-white-light/40 p-2 hover:bg-white-light/90 hover:text-primary dark:bg-dark/40 dark:hover:bg-dark/60" @click="$store.app.toggleTheme('light')">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V14C21 15.8856 21 16.8284 20.4142 17.4142C19.8284 18 18.8856 18 17 18H7C5.11438 18 4.17157 18 3.58579 17.4142C3 16.8284 3 15.8856 3 14V9Z" stroke="currentColor" stroke-width="1.5" />
                                        <path opacity="0.5" d="M22 21H2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                        <path opacity="0.5" d="M15 15H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                    </svg>
                                </a>
                            </div>

                            <div class="dropdown flex-shrink-0" x-data="dropdown" @click.outside="open = false">
                                <a href="javascript:;" class="group relative" @click="toggle()">
                                    <span><img class="h-9 w-9 rounded-full object-cover saturate-50 group-hover:saturate-100" src="assets/images/user-profile.jpeg" alt="image" /></span>
                                </a>
                                <ul x-cloak x-show="open" x-transition x-transition.duration.300ms class="top-11 w-[230px] !py-0 font-semibold text-dark ltr:right-0 rtl:left-0 dark:text-white-dark dark:text-white-light/90">
                                    <li>
                                        <div class="flex items-center px-4 py-4">
                                            <div class="flex-none">
                                                <img class="h-10 w-10 rounded-md object-cover" src="assets/images/user-profile.jpeg" alt="image" />
                                            </div>
                                            <div class="ltr:pl-4 rtl:pr-4">
                                                <h4 class="text-base">
                                                    John Doe<span class="rounded bg-success-light px-1 text-xs text-success ltr:ml-2 rtl:ml-2">Pro</span>
                                                </h4>
                                                <a class="text-black/60 hover:text-primary dark:text-dark-light/60 dark:hover:text-white" href="javascript:;">johndoe@gmail.com</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <a href="users-profile.html" class="dark:hover:text-white" @click="toggle">
                                            <svg class="h-4.5 w-4.5 ltr:mr-2 rtl:ml-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="12" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
                                                <path opacity="0.5" d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z" stroke="currentColor" stroke-width="1.5" />
                                            </svg>
                                            Dashboard</a>
                                    </li>
                                    <li class="border-t border-white-light dark:border-white-light/10">
                                        <a href="auth-boxed-signin.html" class="!py-3 text-danger" @click="toggle">
                                            <svg class="h-4.5 w-4.5 rotate-90 ltr:mr-2 rtl:ml-2" width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.5" d="M17 9.00195C19.175 9.01406 20.3529 9.11051 21.1213 9.8789C22 10.7576 22 12.1718 22 15.0002V16.0002C22 18.8286 22 20.2429 21.1213 21.1215C20.2426 22.0002 18.8284 22.0002 16 22.0002H8C5.17157 22.0002 3.75736 22.0002 2.87868 21.1215C2 20.2429 2 18.8286 2 16.0002L2 15.0002C2 12.1718 2 10.7576 2.87868 9.87889C3.64706 9.11051 4.82497 9.01406 7 9.00195" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                                                <path d="M12 15L12 2M12 2L15 5.5M12 2L9 5.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            Sign Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- horizontal menu -->
                    <ul class="horizontal-menu hidden border-t border-[#ebedf2] bg-white py-1.5 px-6 font-semibold text-black rtl:space-x-reverse dark:border-[#191e3a] dark:bg-[#0e1726] dark:text-white-dark lg:space-x-1.5 xl:space-x-8">
                        <li class="menu nav-item relative">
                            <a href="index.php" class="nav-link" onclick="javascript:">
                                <div class="flex items-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" fill="currentColor" />
                                        <path d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z" fill="currentColor" />
                                    </svg>
                                    <span class="px-1">Dashboard</span>
                                </div>
                            </a>
                        </li>
                        <li class="menu nav-item relative">
                            <a href="javascript:;" class="nav-link active">
                                <div class="flex items-center">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.97883 9.68508C2.99294 8.89073 2 8.49355 2 8C2 7.50645 2.99294 7.10927 4.97883 6.31492L7.7873 5.19153C9.77318 4.39718 10.7661 4 12 4C13.2339 4 14.2268 4.39718 16.2127 5.19153L19.0212 6.31492C21.0071 7.10927 22 7.50645 22 8C22 8.49355 21.0071 8.89073 19.0212 9.68508L16.2127 10.8085C14.2268 11.6028 13.2339 12 12 12C10.7661 12 9.77318 11.6028 7.7873 10.8085L4.97883 9.68508Z" fill="currentColor" />
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2 8C2 8.49355 2.99294 8.89073 4.97883 9.68508L7.7873 10.8085C9.77318 11.6028 10.7661 12 12 12C13.2339 12 14.2268 11.6028 16.2127 10.8085L19.0212 9.68508C21.0071 8.89073 22 8.49355 22 8C22 7.50645 21.0071 7.10927 19.0212 6.31492L16.2127 5.19153C14.2268 4.39718 13.2339 4 12 4C10.7661 4 9.77318 4.39718 7.7873 5.19153L4.97883 6.31492C2.99294 7.10927 2 7.50645 2 8Z" fill="currentColor" />
                                        <path opacity="0.7" d="M5.76613 10L4.97883 10.3149C2.99294 11.1093 2 11.5065 2 12C2 12.4935 2.99294 12.8907 4.97883 13.6851L7.7873 14.8085C9.77318 15.6028 10.7661 16 12 16C13.2339 16 14.2268 15.6028 16.2127 14.8085L19.0212 13.6851C21.0071 12.8907 22 12.4935 22 12C22 11.5065 21.0071 11.1093 19.0212 10.3149L18.2339 10L16.2127 10.8085C14.2268 11.6028 13.2339 12 12 12C10.7661 12 9.77318 11.6028 7.7873 10.8085L5.76613 10Z" fill="currentColor" />
                                        <path opacity="0.4" d="M5.76613 14L4.97883 14.3149C2.99294 15.1093 2 15.5065 2 16C2 16.4935 2.99294 16.8907 4.97883 17.6851L7.7873 18.8085C9.77318 19.6028 10.7661 20 12 20C13.2339 20 14.2268 19.6028 16.2127 18.8085L19.0212 17.6851C21.0071 16.8907 22 16.4935 22 16C22 15.5065 21.0071 15.1093 19.0212 14.3149L18.2339 14L16.2127 14.8085C14.2268 15.6028 13.2339 16 12 16C10.7661 16 9.77318 15.6028 7.7873 14.8085L5.76613 14Z" fill="currentColor" />
                                    </svg>
                                    <span class="px-1">Tables</span>
                                </div>
                                <div class="right_arrow">
                                    <svg class="h-4 w-4 rotate-90" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </a>
                            <ul class="sub-menu">
                                <li>
                                    <a href="wisata.php">Wisata</a>
                                </li>
                                <li>
                                    <a href="kategori.php">Category</a>
                                </li>
                                <li>
                                    <a href="fasilitas.php">Fasilitas</a>
                                </li>
                                <li>
                                    <a href="user.php">User</a>
                                </li>
                                <li>
                                    <a href="review.php">Review</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </header>
            <!-- end header section -->

            <div class="animate__animated p-6" :class="[$store.app.animation]">
                <!-- start main content section -->
                <ul class="flex space-x-2 rtl:space-x-reverse mb-4">
                    <li>
                        <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
                    </li>
                    <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                        <span>Review</span>
                    </li>
                </ul>

                <div x-data="striped">
                    <div class="mt-3">
                        <h5 class="mb-5 text-lg font-semibold dark:text-white-light md:absolute md:top-[25px] md:mb-0">Data Review</h5>
                        <table id="tableAll" class="table-striped table-hover table-bordered table-compact">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Wisata</th>
                                    <th>Komentar</th>
                                    <th>Rating</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                while ($ambildata = mysqli_fetch_array($datareview)) {
                                    $komentar = $ambildata['komentar'];
                                    $user = $ambildata['username'];
                                    $nama_tempat = $ambildata['nama_tempat'];
                                    $rating = $ambildata['rating'];

                                    if (!isset($wisataRating[$nama_tempat])) {
                                        $wisataRating[$nama_tempat] = [
                                            'totalRating' => 0,
                                            'jumlahReview' => 0
                                        ];
                                    }

                                    $wisataRating[$nama_tempat]['totalRating'] += $rating;
                                    $wisataRating[$nama_tempat]['jumlahReview']++;
                                ?>
                                    <tr>
                                        <td style="width: 10px;"><?= $i++; ?></td>
                                        <td><?= $user; ?></td>
                                        <td><?= $nama_tempat; ?></td>
                                        <td><?= $komentar; ?></td>
                                        <td><?= $rating; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <p class="mt-5 dark:text-gray-300 font-semibold">Data Rata-Rata Rating</p>

                <div class="informasi-tempat grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-5">
                    <?php
                    if (empty($wisataRating)) {
                    ?>
                        <div class="panel h-full">
                            <div class="p-4">
                                <h5 class="text-xl font-semibold mb-2 dark:text-white-light">Tidak Ada Rating</h5>
                                <p class="text-gray-600 mb-2">Maaf, tidak ada rating untuk ditampilkan.</p>
                            </div>
                        </div>
                        <?php
                    } else {
                        foreach ($wisataRating as $nama_tempat => $ratings) {
                            $averageRating = $ratings['totalRating'] / $ratings['jumlahReview'];
                            $roundedRating = round($averageRating, 2);
                            $rateYoID = str_replace(' ', '_', $nama_tempat);
                        ?>
                            <div class="panel h-full">
                                <div class="p-4">
                                    <h5 class="text-xl font-semibold mb-2 dark:text-white-light"><?= $nama_tempat; ?></h5>
                                    <p class="text-gray-600 mb-2">Rating Rata-Rata: <?= $roundedRating; ?>/5</p>
                                    <div id="rateYo_<?= $rateYoID; ?>"></div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>

                <!-- start footer section -->
                <p class="pt-6 text-center dark:text-white-dark ltr:sm:text-left rtl:sm:text-right">
                    © <span id="footer-year">2023</span>. Kelompok 5
                </p>
                <!-- end footer section -->
            </div>
            <!-- end main content section -->
        </div>
    </div>

    <script src="assets/js/highlight.min.js"></script>
    <script src="assets/js/alpine-collaspe.min.js"></script>
    <script src="assets/js/alpine-persist.min.js"></script>
    <script defer src="assets/js/alpine-ui.min.js"></script>
    <script defer src="assets/js/alpine-focus.min.js"></script>
    <script defer src="assets/js/alpine.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script src="assets/js/simple-datatables.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php
            foreach ($wisataRating as $nama_tempat => $ratings) {
                $averageRating = $ratings['totalRating'] / $ratings['jumlahReview'];
                $rateYoID = str_replace(' ', '_', $nama_tempat);
            ?>

                $("#rateYo_<?= $rateYoID; ?>").rateYo({
                    rating: <?= $averageRating; ?>,
                    readOnly: true
                });
            <?php
            }
            ?>
        });
    </script>

    <script>
        document.addEventListener('alpine:init', () => {
            // main section
            Alpine.data('scrollToTop', () => ({
                showTopButton: false,
                init() {
                    window.onscroll = () => {
                        this.scrollFunction();
                    };
                },

                scrollFunction() {
                    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                        this.showTopButton = true;
                    } else {
                        this.showTopButton = false;
                    }
                },

                goToTop() {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                },
            }));

            Alpine.data("modal", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle() {
                    this.open = !this.open;
                },
            }));


            // theme customization
            Alpine.data('customizer', () => ({
                showCustomizer: false,
            }));

            // sidebar section
            Alpine.data('sidebar', () => ({
                init() {
                    const selector = document.querySelector('.sidebar ul a[href="' + window.location.pathname + '"]');
                    if (selector) {
                        selector.classList.add('active');
                        const ul = selector.closest('ul.sub-menu');
                        if (ul) {
                            let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                            if (ele) {
                                ele = ele[0];
                                setTimeout(() => {
                                    ele.click();
                                });
                            }
                        }
                    }
                },
            }));

            Alpine.data('striped', () => ({
                init() {
                    const tableOptions = {
                        sortable: false,
                        searchable: true,
                        perPage: 10,
                        perPageSelect: [10, 20, 30, 50, 100],
                        firstLast: true,
                        firstText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        lastText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M11 19L17 12L11 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> <path opacity="0.5" d="M6.99976 19L12.9998 12L6.99976 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        prevText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M15 5L9 12L15 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        nextText: '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-4.5 h-4.5 rtl:rotate-180"> <path d="M9 5L15 12L9 19" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/> </svg>',
                        labels: {
                            perPage: '{select}',
                        },
                        layout: {
                            top: '{search}',
                            bottom: '{info}{select}{pager}',
                        },
                    };
                    const datatable5 = new simpleDatatables.DataTable('#tableAll', tableOptions);

                },
            }));
        });
    </script>
</body>

</html>