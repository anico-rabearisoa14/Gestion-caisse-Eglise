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

    header {
        /* background-color: #2c3e50; */
        color: #2c3e50;
        padding: 15px 0;
        text-align: center;
    }

    header h1 {
        font-size: 2rem;
        letter-spacing: 1px;
    }

    nav {
        background-color: #2c3e50;
        /* #34495e; */
        display: flex;
        justify-content: flex-start;
        gap: 30px;
        padding: 12px 12px;
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
        padding: 20px;
        color: #ffffff;
        font-size: 0.9rem;
        position: fixed;
        bottom: 0;
        right: 0px;
        left: 0px;
        /* border: 1px solid #3498db8f; */
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
        box-shadow: 2px 2px 6px #272626e1;

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
        height: 3px;
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

    .data-table tr{
        text-align: center;
    }
    .table-index{
        width: 100px;
    }
</style>