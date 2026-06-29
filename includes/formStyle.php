<style>
  .form-container {
    display: flex;
    flex-direction: column;

    gap: 5px;
    padding: auto;
  }

  .wrapper {
    background-color: white;
    margin: 30px auto;
    padding: 8px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.37);
    max-width: 400px;
    min-width: 400px;
    margin-left: auto;
    margin-right: auto;
  }


  /* the info card */

  .info-liste {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .info-liste li {
    margin-top: 6px;
    margin-bottom: 10px;
  }



  /* message styles */
  .message-box {
    display: flex;
    justify-content: center;
    border-radius: 8px;
    max-width: 200px;
    height: 45px;
    padding: 0px 12px;

    position: fixed;
    bottom: 100px;
    left:500px;
    z-index: 99;
  }

  .message-box p {
    color: aliceblue;
    font-size: 1rem;
    font-weight: bold;
  }

  .success-box{
    background-color: rgb(22, 190, 87);
  }



  /* confirmation prompt styles */
  
.action-title{
  font-size: 1rem;
  font-weight: bolder;
  justify-self: center;
  margin-bottom: 10px;
}

.prompt-box{
  display: flex;
  flex-direction: column;
  gap: 6px;
  background-color: rgb(255, 255, 255);
  padding: 10px;
  border-radius: 8px;
  width: 400px;
}

.button-layout{
  display: flex;
  justify-content: center;
  gap: 4px;
  padding: 6px;
  height: 45px;
}
.button-layout button{
  padding: 3px 8px;
  font-size: 1rem;
  border-radius: 4px;
  width: 100%;
  max-width: 100px;
}

.accept-btn{
  background-color: #cf1d1d;
  color: white;
  border: none;
}
.accept-btn:hover{
  background-color: #b11818;
}
.refus-btn{
  background-color: #ffffffc5;
  color: #061535;
  border: 1px solid #313131b7;
}

.refus-btn:hover{
  background-color: #7a7f8373;
}
</style>