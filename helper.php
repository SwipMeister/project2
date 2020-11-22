<?php


class Helper {

    public function field_validator($fieldnames){
        // provided argument should be an array.
        if(is_array($fieldnames)){
            // error set to false so we can return error messages later on
           
            $error = False; // 0

            foreach ($fieldnames as $fieldname) {
                // als  deze niet gezet zijn error = true
                if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
      
                  $error = True; // 1
      
                  $errorMsg = "* Velden met een ster/asteriks zijn verplicht.";
                } 
                
              }

              if (!$error) { // ($error !== TRUE)
                    // zorgt ervoor dat de if in betreffende file TRUE is
                    return True;
                }

                return False;

        }else{
            // als t geen array is print:
            echo 'NO ARRAY NO BUENO';
        }
    }

}