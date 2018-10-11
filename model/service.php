<?php

class service extends database {

    public function selectService() {
        $request = 'SELECT `serviceName`, `description`, `id` '
                . 'FROM `service`';
        $getService = $this->db->prepare($request);
        if ($getService->execute()) {
            return $getService->fetchAll();
        }
    }

}

?>
