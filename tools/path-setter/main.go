package main

import (
	"bufio"
	"fmt"
	"os"
	"os/exec"
	"path/filepath"
	"strings"
)

const (
	colorReset  = "\033[0m"
	colorRed    = "\033[31m"
	colorGreen  = "\033[32m"
	colorYellow = "\033[33m"
	colorCyan   = "\033[36m"
	colorBold   = "\033[1m"
)

func main() {
	fmt.Println(colorCyan + "========================================" + colorReset)
	fmt.Println(colorCyan + "      WinAudit PHP Path Setter        " + colorReset)
	fmt.Println(colorCyan + "========================================" + colorReset)

	phpDir := promptForPHPDir()
	if phpDir == "" {
		fmt.Println(colorRed + "Error: No valid PHP directory provided. Exiting." + colorReset)
		return
	}

	if !validatePHP(phpDir) {
		fmt.Println(colorRed + "Error: php.exe not found in the specified directory. Please ensure the path is correct." + colorReset)
		return
	}

	fmt.Printf(colorYellow+"Attempting to add '%s' to your User PATH...\n"+colorReset, phpDir)

	if err := addToUserPath(phpDir); err != nil {
		fmt.Printf(colorRed+"Failed to add path to environment variables: %v\n"+colorReset, err)
		fmt.Println(colorYellow + "Hint: You might need to run this program as an administrator for system-wide changes, or manually add the path via System Properties -> Environment Variables." + colorReset)
	} else {
		fmt.Println(colorGreen + "Successfully added PHP directory to your User PATH!" + colorReset)
		fmt.Println(colorYellow + "\nIMPORTANT: For changes to take effect in current terminals, close and reopen them." + colorReset)
	}
}

func promptForPHPDir() string {
	reader := bufio.NewReader(os.Stdin)
	fmt.Print("Enter the directory containing php.exe (e.g., C:\\xampp\\php): ")
	input, _ := reader.ReadString('\n') // Corrected to use '\n'
	dir := strings.TrimSpace(input)
	return dir
}

func validatePHP(dir string) bool {
	phpExePath := filepath.Join(dir, "php.exe")
	_, err := os.Stat(phpExePath)
	return err == nil
}

func addToUserPath(dir string) error {
	powershellCmd := fmt.Sprintf(`
$phpDir = "%s"
$currentPath = [Environment]::GetEnvironmentVariable("Path", "User")
if (-not $currentPath.Contains($phpDir)) {
    $newPath = $currentPath + ";" + $phpDir
    [Environment]::SetEnvironmentVariable("Path", $newPath, "User")
    Write-Host "Successfully added '$phpDir' to User PATH."
} else {
    Write-Host "'$phpDir' is already in User PATH."
}
`, dir)

	cmd := exec.Command("powershell", "-NoProfile", "-Command", powershellCmd)
	cmd.Stdout = os.Stdout
	cmd.Stderr = os.Stderr
	return cmd.Run()
}
