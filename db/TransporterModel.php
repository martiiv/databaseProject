<?php

/**
 * Class TransporterModel - Handles transporter functionality like add new-, edit- and delete transporter
 */
class TransporterModel extends DB
{
    /**
     * Add a new transporter
     * @param array $resource The data to be put into the new transporter
     * @return array containing the newly created transporter
     */
    function addTransporter(array $resource): array
    {
        $this->db->beginTransaction();

        $res = array();

        $transporter = $resource['transporter'];

        $queryTransporter = 'INSERT INTO transporters (name) VALUES (:name)';

        $stmt = $this->db->prepare($queryTransporter);
        $stmt->bindValue(':name', $transporter);
        $stmt->execute();
        $this->db->commit();

        $res['name'] = $transporter;
        return $res;
    }

    /**
     * Edit a transporter - change the transporters name
     * @param array $resource The data of the transporter to be changed (new name)
     * @param string $oldName the old name of the transporter
     * @return array containing the newly edited transporter with the new data
     */
    function editTransporter(array $resource, string $oldName): array
    {
        $this->db->beginTransaction();

        $res = array();

        $transporter = $resource['transporter'] ?? null;

        $queryTransporter = 'UPDATE transporters SET name = (:name) WHERE name = (:oldName)';

        $stmt = $this->db->prepare($queryTransporter);
        $stmt->bindValue(':name', $transporter);
        $stmt->bindValue(':oldName', $oldName);
        $stmt->execute();
        $this->db->commit();

        $res['name'] = $transporter;
        return $res;
    }

    /**
     * Delete a transporter
     * @param string $name of the transporter
     * @return bool true if transporter got successfully deleted, false otherwise
     */
    function deleteResource(string $name): bool
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM transporters WHERE name = (:name)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->execute();

        $deleted = true;

        $this->db->commit();

        return $deleted;
    }
}