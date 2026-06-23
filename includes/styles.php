<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffffff;
        color: #2c3e50;
        line-height: 1.6;
    }

    nav {
        background-color: #2c3e50;
        /* #34495e; */
        display: flex;
        justify-content: flex-start;
        gap: 30px;
        padding: 12px 12px;
        position: sticky;
        top: 0;
        z-index: 100;
    }

    nav a {
        color: #ecf0f1;
        text-decoration: none;
        font-weight: 500;
        padding: 6px 4px;
        transition: color 0.2s ease;
    }

    nav a:hover {
        color: #3498db;
    }

    nav a.active {
        color: #3498db;
        border-bottom: 2px solid #3498db;
    }

    header {
        background-color: #ffffff;
        color: #2c3e50;
        padding: 15px 0;
        text-align: center;
        position: sticky;
        top: 63px;
        z-index: 99;
    }

    header h1 {
        font-size: 2rem;
        letter-spacing: 1px;
    }

    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.21);
    }

    .container h2 {
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .container p {
        margin-bottom: 12px;
        color: #555;
    }

    .info-box {
        background-color: #eaf4fc;
        border-left: 4px solid #3498db;
        padding: 12px 16px;
        margin-top: 20px;
        border-radius: 4px;
    }

    footer {
        text-align: center;
        color: #ffffff;
        padding: 8px;
        font-size: 0.8rem;
        height: 40px;
        position: fixed;
        bottom: 0;
        right: 0px;
        left: 0px;
        background-color: #2c3e50;
    }


    /* Button styles */
    button {
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .submit-btn {
        padding: 10px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        background-color: #3498db;
    }

    .submit-btn:hover {
        background-color: #2980b9;
    }

    .submit-btn {
        font-weight: bold;
        background-color: #3498db;
        margin-top: 10px;
    }

    .close-btn {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background-color: #cf1d1d;
        color: white;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 2px 2px 6px #27262669;

    }

    .close-btn:hover {
        background-color: #bd2929;
        transform: scale(.85);
        /* transform: rotate(20deg); */
    }


    .normal-btn {
        padding: 6px;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        background-color: #3498db;
    }

    .normal-btn:hover {
        background-color: #2980b9;
    }

    /* style for titles  */
    .form-title {
        text-align: center;
        margin-top: 4px;
        margin-bottom: 8px;
    }

    /* input styles */
    input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    hr {
        margin-bottom: 25px;
        height: 2px;
        border: none;
        border-radius: 9px;
        background-color: #2c3e50;
        /* #2980b9; */
    }

    h4 {
        margin-top: 0;
    }

    /* modal class */
    .centered-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        /* Centers horizontally */
        align-items: center;
        /* Centers vertically */
        background: rgba(0, 0, 0, 0.53);
        transition: all 4s ease-in-out;
        z-index: 999999;
    }

    .window-decoration {
        display: flex;
        justify-content: flex-end;
        border: 1px soilid;
    }


    /* styles for all the tables */
    .data-table {
        border-collapse: collapse;
        width: 100%;
        max-width: 1050px;
        margin: 5px auto;
    }

    .data-table th {
        color: #ecf0f1;
        background-color: #2c3e50;
    }

    .data-table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    .data-table tr {
        text-align: center;
    }

    .table-index {
        width: 100px;
    }

    /* buttons container */
    .button-container {
        display: flex;
        gap: 5px;
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.37); */
        width: 100%;
        max-width: 1050px;
        margin: auto;
    }



    .search-bar {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 6px;
        overflow: hidden;
    }

    .search-bar input {
        border: none;
        outline: none;
        padding: 8px 12px;
        flex: 1;
    }

    .search-bar button {
        background: #3b4a6b;
        color: white;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        border-top-right-radius:6px;
        border-bottom-right-radius:6px;
        margin-right: 2px;
    }



    /* CRUD buttons */
    .btn-create {
        color: #e05c6b;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-read {
        color: #d44f6e;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-update {
        color: #7b6fb0;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-delete {
        color: #3b4a6b;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }
</style>