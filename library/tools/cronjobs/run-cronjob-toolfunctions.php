<?php
//how to cron: https://wordpress.stackexchange.com/questions/179694/wp-schedule-event-every-day-at-specific-time
function run_cronjob_toolfunctions()
{

///this will be the main directory for the cronjob to run the updates for bids, links, clicks, and more
    require_once(get_template_directory() . '/library/tools/tools-functions.php'); //function update_tool_bids will be called from omt_datahost
    require_once(get_template_directory() . '/library/tools/sql/sql_datahost.php');
    require_once(get_template_directory() . '/library/tools/sql/sql-clicks.php');
    require_once(get_template_directory() . '/library/tools/sql/sql-tool-single-clickcalculation.php');
    require_once(get_template_directory() . '/library/json/json_tools.php');
    require_once(get_template_directory() . '/library/tools/cleanup-clicks.php');

    sql_tools();
//************************************************************************************************************************
//FUNCTIONALITY:
// 1. SYNC ALL TOOLS FROM WP DATABASE AND PUSH INTO omt_datahost DATABASE => omt_tools FOR FURTHER COLLABORATION
// 2. WHILE CYCLING THROUGH ALL TOOLS, COLLECT THEIR CORRESPONDING TRACKING LINKS AND PUSH INTO omt_trackinglinks
//**************
// 3. IF A TRACKING LINK IS NEW, CREATE AN EMPTY BID IN omt_bids TABLE - if it is not new:
// 4. CALL update_tool_bids => WHILE WE MAKE A LOOP THROUGH ALL TOOLS AND BIDS, UPDATE THE CURRENTLY ACTIVE BID VALUE INTO WORDPRESS DATABASE
//************************************************************************************************************************

    get_api_all_clicks();
//************************************************************************************************************************
//// FUNCTIONALITY:
// 1. CONNECT TO CLICKMETER API AND COLLECT THE LAST 100CLICKS.
// WE ASSUME THAT THERE WILL BE LESS THAN 100 CLICKS BETWEEN THE CRON RUNS
// (nag clickmeter support to improve this when omt is getting rich on >100clicks/5min / hope building this 500k platform for 1/10th than rest of the world will get rewarded then)
//**************
// 2. USING THE TIMESTAMPS FROM CLICKS AND TIMESTAMPS FROM BIDS (valid_from/valid_until) WE KNOW THE EXACT COST PER CLICK
// SO CAN CALCULATE THE AVERAGE LAST 20 COST FOR CLICKS ON SINGLE-TOOL AND KEEP PRINTING MONEY => SEE FUNCTION calculate_clickcosts() on that one!
// !!!AVERAGES WILL BE CALCULATED ON NEXT FUNCTION!!!
//************************************************************************************************************************

    cleanup_clicks_by_bots();
//************************************************************************************************************************
//// FUNCTIONALITY:
/// 1. Fine all IPs with multiple Clicks. Run a "red-flagging"-Skript to mark IPs with multiple clicks per second with flags. If a Flag to Click Ratio is too high,
/// the given IP will be added to the omt_banlist table for its current clicktimeframe +/- 90days (so older or newer clicks from new Users with this given flexible IP wont get banned as well!
/// 2. Identify "multi-Clicks on same Category" by Users. Because we have up to 3 Tracking Links => Buttons per Tool (website, pricing, trial), a user
/// could click each of them while being in a given category. This would be producing 3 Clicks on those 3 Tracking links (1 each) technically. This part
/// of the script tries to identify such multi-clicks and erase them so only the 1 valid Click per Category we desire will remain.
/// Timeframe for that query: 12hours before and after each click.
//************************************************************************************************************************

    calculate_clickcosts();
//************************************************************************************************************************
//// FUNCTIONALITY:
/// 1. CHECK FOR THE FIRST CLICK; IF ITS ON SINGLE PAGE WE DONT HAVE AN AVERAGE YET => TAKE AVERAGE OF BIDDING COSTS
/// 2. TAKE THE AVERAGE OF THE LAST (up to) 20 CLICK COSTS SUBSEQUENTLY TO USE THIS AVERAGE ON FUTURE SINGLE-TOOL-PAGE-CLICKINGS
/// 3. COLLECT ALL COSTS FOR A GIVEN TOOL AND PUSH INTO "current_cost" column FOR MONTHLY CALCULATION VS BUDGETA
//************************************************************************************************************************

    calculate_balance();
    //************************************************************************************************************************
//// FUNCTIONALITY:
/// 1. GET ALL USERS MIT ROLE TOOLANBIETER
/// 2. COLLECT THEIR TOOLS AND THE TOTAL COST FROM EACH, SUM IT UP TO TOTAL ACCOUNT COSTS (omt_tools)
/// 3. COLLECT ALL EINZAHLUNGEN FROM omt_einzahlungen
/// 4. WRITE THE CALCULATED BALANCE FROM EINZAHLUNGEN - COSTS INTO omt_guthaben
    //************************************************************************************************************************

    compare_budgets_costs();
//************************************************************************************************************************
//// FUNCTIONALITY:
/// 1. LOOP THROUGH ALL TOOLS TO FETCH THEIR COSTS; ADD THEM UP; COMPARE SINGLE TOOL BUDGET VS SINGLE TOOL COSTS AND TOTAL BUDGET VS TOTAL COST
/// => CHANGE "Buttons Anzeigen" Value to true or false accordingly
//************************************************************************************************************************

    notification_on_low_budget();
    notification_on_no_budget();
//************************************************************************************************************************
//// FUNCTIONALITY:
/// LOOP THROUGH ALL GUTHABEN-ROWS, CHECK FOR LOW AND ZERO BALANCES, SEND A MAIL WARNING FOR LOW BALANCE IF BELOW 50€ AND A WARNING FOR EMPTY BALANCE IF BALANCE IS 1 OR LESS
/// WILL NOT BE RUN ON TENTH DAY OF MONTH (Cheap Solution :-( )
//************************************************************************************************************************


    month_end_stats();
//************************************************************************************************************************
//// FUNCTIONALITY:
/// ON TENTH DAY OF MONTH: Set Guthaben Alert (when below 50€) to Zero on all accounts.
//************************************************************************************************************************


///WHEN ALL DONE, WE NEED TO RE-SYNC THE JSON FILE!
   json_tools();
}
?>
