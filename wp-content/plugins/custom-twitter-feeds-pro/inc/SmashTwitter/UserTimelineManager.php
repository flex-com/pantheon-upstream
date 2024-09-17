<?php
/**
 * Class UserTimelineManager
 *
 * @since 1.0
 */
namespace TwitterFeed\SmashTwitter;
class UserTimelineManager
{

	const USERS_TIMLINE_OPTIONS = 'ctf_timeline_users';

	/**
	 * Get List Of Timline Users
	 *
	 * @return array
	 *
	 * @since XX
	 */
	public static function get_users()
	{
		return get_option(self::USERS_TIMLINE_OPTIONS, []);
	}

	/**
	 * Get User ID
	 *
	 * @return string|boolean
	 *
	 * @since XX
	 */
	public static function get_user_id($screen_name)
	{
		$users_list = self::get_users();
		if (empty($screen_name)) {
			return false;
		}
		$screen_name = str_replace('@', '', $screen_name);

		//Check if user exist
		$user_index = array_search(
			$screen_name,
			array_column($users_list, 'screen_name')
		);

		return false !== $user_index ? $users_list[$user_index]['rest_id'] : false;
	}

	/**
	 * Add New or Update User Timeline
	 * Check if user exists then we updated (UserName)
	 * else we add it!
	 *
	 * @return array
	 *
	 * @since XX
	 */
	public static function add_update_user($user = [])
	{
		$users_list = self::get_users();
		if (!empty($user['screen_name']) && !empty($user['rest_id'])) {
			//Check if user exist
			$user_index = array_search(
				$users_list,
				array_column($user, 'rest_id')
			);
			if (false !== $user_index) {
				$users_list[$user_index] = $user;
			} else {
				array_push(
					$users_list,
					$user
				);
			}
			update_option(self::USERS_TIMLINE_OPTIONS, $users_list);
		}
		return $users_list;
	}

	/**
	 * Delete User from the list
	 *
	 * @return array
	 *
	 * @since XX
	 */
	public static function delete_user($user = [])
	{
		$users_list = self::get_users();
		if (!empty($user['screen_name']) && !empty($user['rest_id'])) {
			$user_index = array_search(
				$users_list,
				array_column($user, 'rest_id')
			);
			if (false !== $user_index) {
				unset($users_list[$user_index]);
				update_option(self::USERS_TIMLINE_OPTIONS, $users_list);
			}
		}
		return $users_list;
	}


}