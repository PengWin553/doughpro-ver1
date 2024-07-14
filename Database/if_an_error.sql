-- PASTE THIS TO THE DOUGHPRO SQL IF AN ERROR OCCURS DURING STOCK IN ADD

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_current_stock` (IN `p_inventory_id` INT)   BEGIN
    DECLARE total_stock INT;

    -- Calculate the total stock for the given inventory_id
    SELECT IFNULL(SUM(quantity), 0) INTO total_stock
    FROM stocks_table
    WHERE inventory_id = p_inventory_id;

    -- Update the current_stock in the inventory_table
    UPDATE inventory_table
    SET current_stock = total_stock
    WHERE inventory_id = p_inventory_id;
END$$

DELIMITER ;