import 'package:flutter/material.dart';
import 'package:untitled/Authtentication/Login.dart';

import '../jsonModel/user.dart';
import 'Account.dart';
import 'BestSellingPage.dart';
import 'HomePage.dart';
import 'ProductsPage.dart';


class dashboard extends StatefulWidget {
  const dashboard({super.key});

  @override
  State<dashboard> createState() => _dashboardState();
}

class _dashboardState extends State<dashboard> {
  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'UI Demo',
      home: DefaultTabController(
        length: 3,
        child: Scaffold(
          appBar: AppBar(
            title: Row(
              mainAxisSize: MainAxisSize.min, // This ensures that the row takes the minimum space
              children: <Widget>[
                Image.asset(

                  'lib/assets/trangchu.png', // Replace with your asset's image path
                  height: 35, // Adjust the size to fit within your app bar
                ),
                HomeIconPopupMenu(onRefresh: () {  },),

                const SizedBox(width: 1), // Gives some space between the image and text
                const Text('DANH MỤC'),
              ],
            ),
            actions: <Widget>[
              IconButton(
                icon: const Icon(Icons.search),
                onPressed: (){

                }

              ),
              IconButton(
                icon: const Icon(Icons.shopping_cart),
                onPressed: () {
                  // Handle the shopping cart action
                },
              ),
            ],
            bottom: const TabBar(
              tabs: [
                Tab(text: 'Trang chủ'),
                Tab(text: 'Bán chạy'),
                Tab(text: 'Sản phẩm'),
              ],
            ),
          ),
          body: TabBarView(
            children: [
              HomePage(),       // Your custom widget for the "Trang chủ" tab
              BestSellingPage(), // Your custom widget for the "Bán chạy" tab
              ProductsPage(),    // Your custom widget for the "Sản phẩm" tab
            ],
          ),
      ),
      ),
    );
  }
}

class HomeIconPopupMenu extends StatelessWidget {
  final VoidCallback onRefresh;

  const HomeIconPopupMenu({Key? key, required this.onRefresh})
      : super(key: key);

  @override
  Widget build(BuildContext context) {
    return PopupMenuButton<String>(
      onSelected: (String result) {
        // Handle the action based on the selected value

        if (result == 'logout') {
          // Đẩy màn hình đăng nhập vào và xóa tất cả các màn hình khác trên ngăn xếp định tuyến
          Navigator.of(context).pushAndRemoveUntil(
            MaterialPageRoute(builder: (context) => loginScreen()),
                (Route< dynamic> route) => false,
               // không giữ route nào khác trong stack
          );
        }
        else if  (result == 'account_info') {
          User someUserObject = User();
          // Đẩy màn hình đăng nhập vào và xóa tất cả các màn hình khác trên ngăn xếp định tuyến
          Navigator.of(context).push(
            MaterialPageRoute(builder: (context) =>  Account(user: someUserObject )),

            // không giữ route nào khác trong stack
          );
        }

      },
      itemBuilder: (BuildContext context) =>
      <PopupMenuEntry<String>>[
        const PopupMenuItem<String>(
          value: 'account_info',
          child: Text('Thông tin tài khoản'),
        ),
        const PopupMenuItem<String>(
          value: 'logout',
          child: Text('Đăng xuất'),
        ),
        const PopupMenuItem<String>(
          value: 'add_product',
          child: Text('Thêm sản phẩm'),
        ),
        // More items can be added here
      ],
      icon: const Icon(Icons.more_vert), // Adjust the icon if necessary
      padding: EdgeInsets.zero, // Set padding to zero if needed
    );
  }
}

