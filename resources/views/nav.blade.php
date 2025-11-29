<style>
        nav {
        flex-shrink: 0;
        height: 60px;
        width: 100%;
        padding: 0 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: rgb(19, 19, 16);
        box-shadow: 0px 1px 3px #1b1b1b;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    /* Left = brand */
    nav .nav-left {
        display: flex;
        align-items: center;
    }
        .nav-right a.active {
            color: #e63946;
        }
    

    .nav-brand {
        color: white;
        font-size: 1.5rem;
        font-weight: bold;
        text-decoration: none;
    }
    .nav-brand span {
        color: #e63946;
    }

    /* Right = links */
    nav .nav-right {
        display: flex;
        align-items: center;
    }

    .nav-right ul {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .nav-right li {
        margin-left: 15px;
    }

    .nav-right a {
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 6px 10px;
        border-radius: 4px;
    }

    .nav-right a.active {
        color: #e63946;
    }

    .nav-right a:hover {
        color: #e63946;
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* ✅ Mobile responsive */
    @media (max-width: 580px) {
        nav {
            flex-direction: column;
            height: auto;
            padding: 0.5rem;
        }

        nav .nav-left,
        nav .nav-right {
            justify-content: center;
            margin: 5px 0;
        }

        .nav-right ul {
            flex-wrap: wrap;
            justify-content: center;
        }

        .nav-right li {
            margin: 5px 10px;
        }
    }
</style>

        <div class="nav-left">
           <a href="{{ route(name: 'home') }}" class="nav-brand">Fast<span>Lan</span></a>
        </div>
        <div class="nav-middle">
        </div>
        <div class="nav-right">
            <ul>
                <li><a href="/digilink/public">Home</a></li>
                <li><a href="login">Login</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>