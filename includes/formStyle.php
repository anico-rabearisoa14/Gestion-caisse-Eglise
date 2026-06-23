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
    left:12px;
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
}

.prompt-box{
  display: flex;
  flex-direction: column;
  gap: 6px;
  background-color: rgb(255, 255, 255);
  padding: 10px;
  border-radius: 8px;
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
  color: white;
  border: none;
  border-radius: 4px;
  width: 100%;
  max-width: 100px;
}

.accept-btn{
  background-color: green;
}

.refus-btn{
  background-color: rgb(128, 15, 0);
}
</style>