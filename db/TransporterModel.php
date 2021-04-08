<?php


class TransporterModel extends DB
{
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

    function editTransporter(array $resource, string $oldName): array
    {
        $this->db->beginTransaction();

        $res = array();

        $transporter = $resource['transporter'];

        $queryTransporter = 'UPDATE transporters SET name = (:name) WHERE name = (:oldName)';

        $stmt = $this->db->prepare($queryTransporter);
        $stmt->bindValue(':name', $transporter);
        $stmt->bindValue(':oldName', $oldName);
        $stmt->execute();
        $this->db->commit();

        $res['name'] = $transporter;
        return $res;
    }

    function deleteResource(string $name): string
    {
        $this->db->beginTransaction();

        $query = 'DELETE FROM transporters WHERE name = (:name)';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':name', $name);
        $stmt->execute();

        $this->db->commit();

        $success = "Successfully deleted transporter: " . $name . ".";

        if (strlen($success) != 0) {
            return $success;
        } else {
            $success = "Failed to delete transporter: " . $name . ".";
            return $success;
        }
    }
}