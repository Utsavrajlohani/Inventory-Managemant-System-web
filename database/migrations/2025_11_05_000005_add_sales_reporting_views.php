<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddSalesReportingViews extends Migration
{
    public function up()
    {
        // Store current SQL mode
        DB::statement("SET @OLD_SQL_MODE = @@sql_mode");
        
        // Set SQL mode to allow our grouping
        DB::statement("SET sql_mode = ''");

        // Daily sales view
        DB::statement("CREATE OR REPLACE VIEW daily_sales AS
            SELECT 
                DATE(MIN(sales.sold_at)) as sale_date,
                sales.product_id,
                products.name as product_name,
                SUM(sales.quantity) as total_quantity,
                SUM(sales.total_price) as total_amount,
                COUNT(*) as number_of_sales
            FROM sales
            JOIN products ON sales.product_id = products.id
            GROUP BY DATE(sales.sold_at), sales.product_id, products.name
            ORDER BY sale_date DESC
        ");

        // Weekly sales view
        DB::statement("CREATE OR REPLACE VIEW weekly_sales AS
            SELECT 
                YEARWEEK(MIN(sales.sold_at)) as sale_week,
                DATE(MIN(sales.sold_at) - INTERVAL WEEKDAY(MIN(sales.sold_at)) DAY) as week_start,
                sales.product_id,
                products.name as product_name,
                SUM(sales.quantity) as total_quantity,
                SUM(sales.total_price) as total_amount,
                COUNT(*) as number_of_sales
            FROM sales
            JOIN products ON sales.product_id = products.id
            GROUP BY YEARWEEK(sales.sold_at), sales.product_id, products.name
            ORDER BY sale_week DESC
        ");

        // Monthly sales view
        DB::statement("CREATE OR REPLACE VIEW monthly_sales AS
            SELECT 
                DATE_FORMAT(MIN(sales.sold_at), '%Y-%m-01') as month_start,
                sales.product_id,
                products.name as product_name,
                SUM(sales.quantity) as total_quantity,
                SUM(sales.total_price) as total_amount,
                COUNT(*) as number_of_sales
            FROM sales
            JOIN products ON sales.product_id = products.id
            GROUP BY DATE_FORMAT(sales.sold_at, '%Y-%m-01'), sales.product_id, products.name
            ORDER BY month_start DESC
        ");

        // Reset SQL mode back to default
        DB::statement("SET sql_mode = @OLD_SQL_MODE");
    }

    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS daily_sales");
        DB::statement("DROP VIEW IF EXISTS weekly_sales");
        DB::statement("DROP VIEW IF EXISTS monthly_sales");
    }
}