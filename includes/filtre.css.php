<style>
:root {
    --text-sm: 0.85rem;   /* table data */
    --text-base: 1rem;    /* body */
    --text-lg: 1.25rem;   /* labels */
    --text-xl: 2rem;      /* page title */
}

h1 { font-size: var(--text-xl); }
label { font-size: var(--text-base); }
td, th { font-size: var(--text-sm); }
p{ font-size: var(--text-sm);}

#montant-total{
    font-size: var(--text-sm);
}

    /* ─── Layout  */
    #container {
        max-width: 900px;
        margin: 4px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        align-items: stretch;
        gap: 10px;
    }

    @media only screen and (max-width: 600px) {
        
    }


    /* ─── Filter Panel  */
    .main-form-wrapper {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: stretch;
        gap: 10px;
        background-color: #ffffff;
        border-radius: 12px;
        max-width: 100%;
        max-height: 345px;
        padding: 4px 10px;
    }

    .reponse-filtre {
        border: 1px solid black;
        border-right: 4px solid black;
        border-left: 4px solid black;
        border-radius: 12px;
        padding: 15px;
    }

    /* ─── Form Elements  */
    form {
        display: flex;
        flex-direction: column;
        gap: 12px;
        max-width: 400px;
    }

    label {
        color: rgb(7, 67, 131);
        /* font-weight: bold; */
        margin-right: 5px;
    }

    select {
        padding: 8px;
        border-radius: 6px;
        color: white;
        background-color: #3b4a6b;
    }

    #select-area {
        display: flex;
        min-width: 190px;
        width: 100%;
        justify-content: space-evenly;
        border: 1px solid #3b4a6b;
        border-radius: 6px;
        margin: 10px 0 25px;
        padding: 4px;
    }

    .input-wrapper {
        display: flex;
        justify-content: center;
        gap: 6px;
    }

    .date-input {
        display: flex;
        justify-content: center;
    }

    .date-begin {
        background-color: white;
        color: #18233b;
    }

    .date-end {
        background-color: white;
        color: #3b4a6b;
    }

    /* ─── Button  */
    .button-layout {
        display: flex;
        /* justify-content: center; */
    }

    /* ─── Results Table  */
    .filtered-data-table {
        border-collapse: collapse;
        width: 100%;
        max-width: 1050px;
        margin: 5px auto;
        border: 1px solid #a09a9a7c;
    }

    .filtered-data-table th {
        color: #ecf0f1;
        background-color: #2c3e50;
    }

    .filtered-data-table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    .filtered-data-table tr {
        text-align: center;
    }

    /* ─── Feedback  */
    .success {
        color: #27ae60;
        margin-top: 10px;
    }
    #end , #begin {
        text-decoration: underline;
    }
</style>