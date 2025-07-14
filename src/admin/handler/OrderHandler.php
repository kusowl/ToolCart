<?php
include_once ROOT . "config/db_config.php";
include_once ROOT . "class/Orders.php";
$formData=[];
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    if(isset($_GET["id"])){
       $orderId = $_GET["id"];
        try {
            $orderDetails = Orders::getByOrderId($orderId);
            $formData['payment_status'] = $orderDetails->getPaymentStatus();
            $formData['order_status'] = $orderDetails->getStatus();
            $formData['delivery_status'] = $orderDetails->getDeliveryStatus();
            $formData['order_id'] = $orderId;
        } catch (Exception $e) {
            error_log($e->getMessage());
            header('location:dashboard');
        }

    }else{
        $table_heads = ['Order ID', 'User', 'Amount', 'Delivery Status', 'Payment Type', 'Payment Status','Date', 'Order Status'];
        $orders = Orders::getAllOrders(limit: $limit ?? QUERY_LIMIT);
        $table_records = [];
        $records = [];
        foreach ($orders as $ordersRec) {
            $records['id'] = $ordersRec->getId();
            $records['user'] = User::getById($ordersRec->getUserId())->getName();
            $records['amount'] = $ordersRec->getAmount();
            $records['delivery_status'] = ucfirst($ordersRec->getDeliveryStatus());
            $records['payment_type'] = strtoupper( $ordersRec->getPaymentType());
            $records['payment_status'] = ucfirst($ordersRec->getPaymentStatus() ?: 'Pending' );
            $records['date'] = $ordersRec->getDate();
            $records['order_status'] = $ordersRec->getStatus();
            $table_records[] = $records;
        }
        $primaryAction = 'Disabled';
        $primaryActionLink = BASE_URL . "admin/edit_order";
        $deleteLink = 'handler/OrderHandler.php';
    }
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $orderId = $_POST['order_id'];
    $orderStatus = $_POST['order_status'];
    $paymentStatus = $_POST['payment_status'];
    $deliveryStatus = $_POST['delivery_status'];
    try {
        $order = Orders::getByOrderId($orderId);
        $data=[
            'id'=>$orderId,
            'status' => $orderStatus,
            'payment_status' => $paymentStatus,
            'delivery_status' => $deliveryStatus,
        ];
        $order->update($data);
        $_SESSION['messages'] = [
            'success' => "Order status updated successfully"
        ];
        $_SESSION['message_type'] = 'success';
    } catch (Exception $e) {
        $_SESSION['messages'] = [
            'error' => $e->getMessage()
        ];
        $_SESSION['message_type'] = 'error';
        error_log($e->getMessage());
    }
    header('location: order_list');
    exit;
}
