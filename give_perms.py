import os

def main():
	for filename in os.listdir(os.getcwd()):
		if filename.endswith(".html") or filename.endswith(".php"):
			os.chmod(filename, 436)


if __name__ == "__main__":
	main()
							
 
