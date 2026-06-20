<?php
// EGLISE

// CREATE TABLE EGLISE (
//     ideglise VARCHAR(15) PRIMARY KEY,
//     Design VARCHAR(30),
//     Solde INT DEFAULT 0
// );

 // creer une eglise
function createEglise($ideglise ,$Design ,$Solde) {

}
// afficher lse informations d'une eglise
function listeInfoEglise($ideglise) :array {
$info = [ 'id' => '$ideglise'];
return $info;
}


// ENTRE

// CREATE TABLE ENTRE (
//     identre INT AUTO_INCREMENT PRIMARY KEY,
//     ideglise VARCHAR(15),
//     motif VARCHAR(50) NOT NULL,
//     montantEntre INT,
//     dateEntre DATE DEFAULT (CURRENT_DATE),
//     FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
// )

// ajout d'une enregistrement dans l'ENTRE ()
function ajouterEntre($ideglise ,$motif ,$montantEntre ,$dateEntre)
{

}


// SORTIE

// CREATE TABLE SORTIE (
//     idsortie INT AUTO_INCREMENT PRIMARY KEY,
//     ideglise VARCHAR(15),
//     motif VARCHAR(50) NOT NULL,
//     montantSortie INT,
//     dateSortie DATE DEFAULT (CURRENT_DATE),
//     FOREIGN KEY (ideglise) REFERENCES EGLISE(ideglise)
// );


// ajout d'une enregistrement dans la SORTIE ()
function ajouterSortie($ideglise ,$motif ,$montantSortie ,$dateSortie)
{

}
?>