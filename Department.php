<?php
// 7 - Creiamo questa classe perché vogliamo lavorare secondo il paradigma OOP: i dati prelevati dal db li mappiamo direttamente sulla classe, e nel resto del programma lavoriamo sull'oggetto che rappresenta quello che vogliamo prelevare dal db.

class Department {
    public $id;
    public $name;
    public $address;
    public $phone;
    public $email;
    public $website;
    public $head_of_department;

    function __construct($_id, $_name) {
        $this->id = $_id;
        $this->name = $_name;
    }

    // 22 - Creo una funzione per richiamare tutti insieme questi dati.
    public function setContactData($_address, $_phone, $_email, $_website) {
        $this->address = $_address;
        $this->phone = $_phone;
        $this->email = $_email;
        $this->website = $_website;
    }

    // 26 - Creo una funzione che restituisce un array associativo (un oggetto) con in contatti, per facilitarne la stampa.

    public function getContactsAsArray() {
        return [
            "indirizzo" => $this->address,
            "telefono" => $this->phone,
            "email" => $this->email,
            "website" => $this->website
        ];
    }
}