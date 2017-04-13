The php script is set to use a database named 'project 1' and it uses the 'root' user.


Trigger 1:
This trigger is used to check for a valid category when trying to do an insert on the categories table. There are four valid values for the category attribute and if someone tries to enter an invalid value, they will receive an error message.

delimiter $$
    create trigger check_category before insert on categories 
      for each row 
       begin  
      if  new.category != 'Economy' OR new.category != 'Premium' OR new.category != 'Accessibility' OR new.category != 'Carpool' then
       SIGNAL SQLSTATE '45000'   
       SET MESSAGE_TEXT = 'Not a valid category';
       end if; 
    end; 
    $$

Trigger 2:
This trigger is used to check for a valid value in the days attribute when trying to do an insert on the time_slot table. There are three valid values for the days attribute and if someone tries to enter an invalid value, they will recieve an error message.

delimiter $$
    create trigger check_time_slot before insert on time_slot 
      for each row 
       begin  
      if  new.days != 'Week days' OR new.days != 'Weekends' OR new.days != 'Week days/weekends' then
       SIGNAL SQLSTATE '45000'   
       SET MESSAGE_TEXT = 'Not a valid value for days';
       end if; 
    end; 
    $$