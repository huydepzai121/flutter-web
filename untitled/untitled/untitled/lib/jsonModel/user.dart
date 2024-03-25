class User {
  String? id;
  String? name;
  String? email;
  String? phone;
  String? address;
 // String? regdate;

  User(
      { this.id,
         this.name,
         this.email,
         this.phone,
         this.address,
        //  this.regdate,
      });

  User.fromJson(Map<String, dynamic> json) {
    id = json['id'];
    name = json['username'];
    email = json['email'];
    phone = json['phone'];
    address = json['address'];
   // regdate = json['regdate'];

  }
}
