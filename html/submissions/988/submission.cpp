#include <stdio.h>
#include <math.h>

int n, x[1000], b[1000],res=0;

bool snt(int n)
{
    for (long long j=2;j<=sqrt(n);j++)
    if (n%j==0) return false;
    return true;
}

void backtrack(long long i)
{
    for (int j=2;j<=n;j++)
        if ((b[j]==0)&&(snt(x[i-1]+j)))
        {
            b[j]=1;
            x[i]=j;
            if (i<n) backtrack(i+1);
            else if(snt(x[1]+x[n])) res+=1;
            b[j]=0;
        }
}

int main()
{
    scanf("%d",&n);
    n=n*2;
    for (int i=1;i<=n;i++)
        b[i]=0;
        x[1]=1;
        x[n+1]=1;
    backtrack(2);
    printf("%d",res);
}
