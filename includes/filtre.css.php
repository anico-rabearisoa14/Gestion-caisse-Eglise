  <style>
      form {
          display: flex;
          flex-direction: column;
          gap: 12px;
          max-width: 400px;
      }

      .success {
          color: #27ae60;
          margin-top: 10px;
      }

      /* the main body of the page */
      #container {
          max-width: 900px;
          margin: 4px auto;
          padding: 30px;
          background-color: #ffffff;
          border-radius: 8px;
          /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.21); */
          /* border: 1px solid #3b4a6b; */
          display: flex;
          flex-direction: column;
          align-items: center;
      }

      /*  */
      .main-form-wrapper {
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          gap: 10px;
          background-color: #ffffff;
          border: 1px solid #3b4a6b;
          box-shadow: 0px -5px 0px #3b4a6b, 0px 5px 0px #3b4a6b;
          /* ,-2px 0px 0px #3b4a6b , 2px 0px 0px #3b4a6b ; */
          border-radius: 8px;
          max-width: 435px;
          padding: 4px 35px;
      }

      .input-wrapper {
          display: flex;
          justify-content: center;
          gap: 6px;
      }

      label {
          color: rgb(7, 67, 131);
          justify-self: end;
          font-weight: bold;
          margin-right: 5px;
      }


      /* the date input styles */
      .date-input {
          display: flex;
          justify-content: center;
      }

      .date-begin {
          background-color: rgba(23, 153, 185, 0.836);
          color: white;
      }

      .date-end {
          background-color: rgba(20, 173, 97, 0.89);
          color: white;
      }

      /* select area */
      select {
          padding: 8px;
          border-radius: 6px;
          color: white;
          background-color: #3b4a6b;
      }

      #select-area {
          border-radius: 6px;
          border: 1px solid #3b4a6b;
          margin-top: 10px;
          margin-bottom: 25px;
          padding: 8px
      }

      /* button style */
      .button-layout {
          display: flex;
          justify-content: center;
      }

      .state {
          /* background-color: #3b4a6b; */
          /* color: white; */
          /* padding: 3px; */
          /* border-radius: 3px; */
          margin-left: 8px;
          border-bottom: 2px solid #2c3e50;
          /* box-shadow: 0px 1px 0px #2c3e50; */
      }

      /* style of the filter response */
      .reponse-filtre {
          border-left: 4px solid black;
          border-right: 1px solid black;
          border-top: 1px solid black;
          border-bottom: 1px solid black;
          border-radius: 12px;
          padding: 15px;
          margin-top: 65px;
      }

      /*  style for the table  */
      .filtered-data-table {
          border-collapse: collapse;
          width: 100%;
          max-width: 1050px;
          margin: 5px auto;
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
  </style>