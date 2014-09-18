select
	user_id id, concat_ws(' ',user_firstname, user_lastname) name,
	case when user_company like '%Independent Property%' then 'Independent Property Agent'
	else user_company end `company`, user_email email, concat("'",user_phone) phone,
	concat("'",user_cellular) cellular, c.city_name `city`, s.sales_name `area`,
	from_unixtime(user_active,'%Y-%m-%d') active, from_unixtime(user_expired,'%Y-%m-%d') expired,
	user_status status, ifnull(totalOnline,0) totalOnline, ifnull(totalOffline,0) totalOffline
from members m
left join city c on c.city_id=m.city_id
left join sales s on s.sales_id=m.sales_id
where
(
	DATEDIFF( CURDATE(), from_unixtime(user_active,'%Y-%m-%d')) = 80
	or
	DATEDIFF( CURDATE(), from_unixtime(user_active,'%Y-%m-%d')) = 90
)
and m.user_status in('A')
and totalOnline is null
