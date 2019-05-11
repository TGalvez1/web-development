/*
Make a menu for a shop
provide 5 items with varying price
add a cart section to see current cart and add or remove items

*/

#include <iostream>
#include <string>

using std::cout;
using std::endl;
using std::cin;
using std::string;

class Banana {
public:
	double _price;
	string _name;
	int _stock;
	int _index = 0;
	
	Banana() {
		_name = "";
		_price = 0.00;
		_stock = 12;
	}
	Banana(double price, string name, int stock) {
		_price = price;
		_name = name;
		_stock = stock;
	}

	void _removeBanana() {
		_name = "";
		_price = 0.00;
		_stock += 1;
	}

};
const int CAPACITY = 586;
Banana* cart;
int index = 0;
int menu();

void viewItems() {
	
	Banana banana1(5.99, "Ordinary Yellow Greenish Banana", 13);
	Banana banana2(12.99, "Lavish Yellow Banana (no bruises)", 2);
	Banana banana3(150.54, "Golden Banana (Made with gold spray paint)", 70);
	Banana banana4(17.83, "Tiny Little Baby Green Banana", 500);
	Banana banana5(1000.12, "Moldy Banana (Very Moldy, pretty sure its not a banana anymore)", 1);

	Banana bananas[5] = { banana1,banana2,banana3,banana4,banana5 };

	int response = 0;
	
	do {
		system("cls");
		//add banana selected to cart, remove 1 banana from stock
		for (int banana = 0; banana < 5; banana++) {
			if (bananas[banana]._stock > 0) {
				bananas[banana]._index = banana;
				cout << banana + 1 << ".  " << bananas[banana]._name << "  Price:  " << bananas[banana]._price << "  Stock:  " << bananas[banana]._stock << endl;
			}
			else {
				cout << banana + 1 << ".  " << bananas[banana]._name << "  Price:  " << bananas[banana]._price << "  Stock:  " << "Out of stock!" << endl;
			}
			
		}
		cout << "6. Exit to menu" << endl;
		
		cin >> response;
		if (response >= 6 || response <= 0) {
			continue;
		}

		if (bananas[response - 1]._stock <= 0) {
			cout << "There are no more of this banana available" << endl;
			system("pause");
			continue;
		}
		bananas[response - 1]._stock -= 1;
		cart[index] = bananas[response - 1];
		index += 1;
		
	} while (response < 6 && response >= 1);

	menu();
}

void viewCart() {
	int response = 0;

	do {
		system("cls");
		cout << "If you would like to return something, you can do that here:" << endl;
		for (int i = 0; i <= index; i++) {
			if (cart[i]._name != "")
				cout << i + 1 << ".  " << cart[i]._name << "  Price:  " << cart[i]._price << endl;
		}
		cout << index + 1 << ".  Exit to menu" << endl;
		cout << "Banana to remove: ";
		cin >> response;

		if (response > index || response <= 0) {
			continue;
		}
		if (cart[response-1]._name == "") {
			cout << endl << "That banana was already removed!" << endl;
			system("pause");
			continue;
		}
		cart[response-1]._removeBanana();

	} while (response <= index && response > 0);
	menu();
}

int purchaseBananas() {
	double price = 0.00;
	system("cls");
	for (int i = 0; i <= index; i++) {
		if (cart[i]._name != "")
			cout << i + 1 << ".  " << cart[i]._name << "  Price:  " << cart[i]._price << endl;
		price += cart[i]._price;
	}
	char response = ' ';
	cout << endl << "Your total is going to be:  " << price << endl;
	cout << "Are you ready to complete the transaction? (y/n)  ";
	cin >> response;
	if (response == 'y') {
		cout << endl << "Thank you for your purchase!" << endl;
		return 0;
	}
	
	return menu();

}

int menu() {
	system("cls");
	string response = "";
	int iresponse = 0;
	bool error = false;
	char posResponses[4] = { '1', '2', '3', '4'};
	cout << "Welcome to my banana store" << endl;
	cout << "Here are the options:" << endl;
	cout << "1. View bananas in shop" << endl;
	cout << "2. View bananas in cart" << endl;
	cout << "3. Purchase bananas in cart" << endl;
	cout << "4. Exit menu" << endl;
	do {
		error = false;
		cin >> response;
		bool checkResp = false;
		for (int i = 0; i < 4; i++) {
			if (char(response[0]) == posResponses[i]) {
				checkResp = true;
			}
		}
		if (!checkResp) {
			cout << endl << "Your response is not valid, please try again" << endl;
			error = true;
		}
		
	} while (error);

	iresponse = std::stoi(response);

	if (iresponse == 4) {
		return 1;
	}

	switch (iresponse) {
	case 1:
		//view items function
		viewItems();
		break;
	case 2:
		//view cart function
		viewCart();
		break;
	case 3:
		//purchase items in cart function
		purchaseBananas();
		break;
	}

	return 0;
}

int main() {
	cart = new Banana[CAPACITY];
	menu();
	return 0;
}
