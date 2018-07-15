<?php
namespace AppBundle\Constants;

/**
* This class has been developed in order to provide a full list of available user roles
*/

class User {

  /**
  * Simple User Role that has limited access to basic stuff
  */
  const ROLE_USER='ROLE_USER';
  /**
  * Admin User role, used for users that permorm management tasks
  */
  const ROLE_ADMIN='ROLE_ADMIN';
  /**
  * Members are the users and pay a monyhly/yearly subscription.
  * Theese are alowed to have access to some extra functionalities.
  */
  const ROLE_MEMBER='ROLE_MEMBER';

  /**
  * Volunteers are the ones that have access into
  * specific development and org's actions
  */
  const ROLE_VOLUNTEER='ROLE_VOLUNTEER';

  const ALL_ROLES=[
    self::ROLE_USER,
    self::ROLE_ADMIN,
    self::ROLE_MEMBER,
    self::ROLE_VOLUNTEER
  ];
}
